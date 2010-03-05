# This file defines the String#to_html and String#to_inline_html
# methods, which are invoked to transform plain text into HTML.
#
# This particular implementation features the
# Textile formatting system (RedCloth),
# syntax coloring (CodeRay), and smart source
# code sizing (block versus inline display).
#
#--
# Copyright 2006 Suraj N. Kurapati
# See the file named LICENSE for details.

require 'cgi'
require 'digest/sha1'

begin
  require 'rubygems'

  # check for correct versions of the gems we use
  begin
    gem 'RedCloth'
    gem 'coderay'
  rescue LoadError => e
    puts e
    exit 1
  end
rescue LoadError
end

require 'coderay'
require 'redcloth'

class String
  # The content of these HTML tags will be preserved while
  # they are being processed by Textile.  By doing this, we
  # avoid unwanted Textile transformations, such as quotation
  # marks becoming curly (&#8192;), in source code.
  PROTECTED_TAGS = %w[tt code pre]

  # The content of these HTML tags will be preserved
  # *verbatim* throughout the text-to-HTML conversion process.
  VERBATIM_TAGS = %w[noformat]

  # Transforms this string into an *inline* HTML string (one that
  # does not contain any block-level HTML elements at the root).
  def to_inline_html
    to_html true
  end

  # Transforms this string into HTML while ensuring that the
  # result contains one or more block-level elements at the root.
  #
  # If aInline is true, then the resulting HTML will be an *inline* string.
  #
  def to_html aInline = false
    protect(self, VERBATIM_TAGS, true) do |text|
      html = protect(text, PROTECTED_TAGS, false) {|s| s.thru_redcloth aInline }

      # collapse redundant <pre> elements -- a side effect of RedCloth
      while html.gsub! %r{<pre>\s*(<(code|pre)[^>]*>.*?</\2>)\s*</pre>}m, '\1'
      end

      # ensure tables have a border: this *greatly* improves
      # readability in text-mode web browsers like Lynx and w3m
      html.gsub! %r/<table/, '\& border="1"'

      html.thru_coderay
    end
  end

  # Returns the result of running this string through RedCloth.
  #
  # If aInline is true, then the resulting HTML will be an *inline* string.
  #
  def thru_redcloth aInline = false
    red = RedCloth.new self

    if aInline
      red.lite_mode = true
      red.hard_breaks = false
      red.no_span_caps = true
    end

    red.to_html
  end

  # Adds syntax coloring to <code> elements in the given text.  If the
  # <code> tag has an attribute lang="...", then that is considered the
  # programming language for which appropriate syntax coloring should be
  # applied.  Otherwise, the programming language is assumed to be ruby.
  #
  # massimo.zaniboni@profitoss.com: 
  # does not format code.
  #
  def thru_coderay
    # gsub %r{<(code)(.*?)>(.*?)</\1>}m do
    #  atts, code = $2, CGI.escapeHTML($3)

    gsub %r{<(code)(.*?)>(.*?)</\1>}m do
      atts, code = $2, $3
      
      %{<pre>#{code}</pre>}
      
      #%{<pre>#{RedCloth.new(code).to_html}</pre>}
    end
  end

  # Returns a digest of this string's content.
  def digest
    Digest::SHA1.hexdigest(self)
  end

  private

  # Protects the given tags in the given input, passes
  # that protected input to the given block, restores the
  # given tags in the result of the block and returns it.
  #
  # If aVerbatim is true, the content of the elments having the given tags will
  # not be temporarily altered so that process nested elements can be processed.
  #
  def protect aInput, aTags, aVerbatim #:yields: aInput
    raise ArgumentError unless block_given?

    input = aInput.dup
    escapes = {}

    # protect the given tags by escaping them
    aTags.each do |tag|
      input.gsub! %r{(<#{tag}.*?>)(.*?)(</#{tag}>)}m do
        head, body, tail = $1, $2, $3

        # XXX: when we restore protected tags later on, String.gsub! is
        #      removing all single backslashes for some reason... so we
        #      protect against this by doubling all single backslashes first
        body.gsub! %r/\\/, '\&\&'

        orig =
          if aVerbatim
            body
          else
            head << CGI.escapeHTML(CGI.unescapeHTML(body)) << tail
          end

        esc = orig.digest
        escapes[esc] = orig

        esc
      end
    end

    # invoke the given block with the protected input
    output = yield(input)

    # restore the protected tags by unescaping them
    until escapes.empty?
      escapes.each_pair do |esc, orig|
        if output.gsub! esc, orig
          escapes.delete esc
        end
      end
    end

    output
  end
end
