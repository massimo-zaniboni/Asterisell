# Provides Rake tasks to validate and correct HTML files.
#
# This code was adapted by Greg Weber, and is originally by Scott Raymond.
# See http://redgreenblu.com/svn/projects/assert_valid_markup/
#
#--
# Copyright 2008 Greg Weber
# Copyright 2006 Scott Raymond <sco@scottraymond.net>
#
# Permission is hereby granted, free of charge, to any person obtaining
# a copy of this software and associated documentation files (the
# "Software"), to deal in the Software without restriction, including
# without limitation the rights to use, copy, modify, merge, publish,
# distribute, sublicense, and/or sell copies of the Software, and to
# permit persons to whom the Software is furnished to do so, subject to
# the following conditions:
#
# The above copyright notice and this permission notice shall be
# included in all copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
# EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
# MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
# NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
# LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
# OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
# WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

require 'net/http'
require 'digest/md5'
require 'tmpdir'
require 'cgi'
require 'rubygems'

begin
  require 'xmlsimple'
  require 'tidy'

rescue LoadError
  raise <<-EOS

  #{__FILE__}

  To use this plugin, you need to install the following gems:

    gem install xml-simple tidy

  EOS
end

def errors_to_output( errors )
  errors.group_by {|error| error['line']}.
    map {|line, es| "line #{line}:\n  " <<
      ((es.length <= 3 ? es : [es[0], {'content' => '...'}, es[-1]]).
        map{|es| es['content']}.join("\n  "))
      }
end

def assert_valid_markup(fragment)
  filename = File.join Dir.tmpdir, 'markup.' +
    Digest::MD5.hexdigest(fragment).to_s

  begin
    response = File.open filename do |f| Marshal.load(f) end
  rescue
    response = Net::HTTP.start('validator.w3.org').
      post2('/check', "fragment=#{CGI.escape(fragment)}&output=xml")

    File.open( filename, 'w+') { |f| Marshal.dump response, f }
  end

  if markup_is_valid = response['x-w3c-validator-status']=='Valid'
    puts "passed" if $DEBUG
    true
  else
    "W3C ERRORS:\n" <<
      errors_to_output( XmlSimple.xml_in(response.body)['messages'][0]['msg'].
        map do |msg|
          msg['content'] = "#{CGI.unescapeHTML(msg['content'])}"
          msg
        end).join("\n")
  end
rescue SocketError
  # if we can't reach the validator service, just let the test pass
  puts "\nWARNING: could not connect to internet for w3c validation"
  false
end

def output_html_files
  Dir['output/**/*.html'].each {|file| yield file}
end

desc 'show w3c validation errors and warnings (must be online)'
task :validate do
  validate_files do |html|
    res = assert_valid_markup( html )
    if res && res != true
      puts res
      true
    end
  end
end

desc 'show tidy html validation errors and warnings'
task :tidy do
  tidy_up do |tidy|
    if tidy.errors.first
      puts( "Tidy ERRORS:\n" <<
      errors_to_output( tidy.errors.map {|e| e.split($/)}.flatten.map do |l|
        l =~ /\s*line\s*(\d+)\s*(.*)/ || (fail "could not parse tidy error")
        {'line' => $1, 'content' => $2}
      end ).join($/) )
      true
    end
  end
end

namespace 'tidy' do
  desc 'show tidy diagnostic warnings'
  task :warn do
    tidy_up :show_warnings => true do |tidy|
      puts( tidy.diagnostics.map {|t| t.split("\n")}.flatten.
        reject {|l| l =~ /No warnings or errors/}.join($/) )
    end
  end
end

def tidy_up( opts={} )
  Tidy.open( opts ) do |tidy|
    validate_files do |html|
      tidy.clean(html)
      yield tidy
    end
  end
end

def validate_files
  files = output_html_files do |html_file|
    errors = false
    notify :validate, html_file
    html = File.read( html_file )
    puts "\n\n" if yield html
  end

  puts "#{files.size} files validated"
end

# taken from Rails core:
# /trunk/activesupport/lib/active_support/core_ext/enumerable.rb
#--
# Copyright (c) 2005-2007 David Heinemeier Hansson
#
# Permission is hereby granted, free of charge, to any person obtaining
# a copy of this software and associated documentation files (the
# "Software"), to deal in the Software without restriction, including
# without limitation the rights to use, copy, modify, merge, publish,
# distribute, sublicense, and/or sell copies of the Software, and to
# permit persons to whom the Software is furnished to do so, subject to
# the following conditions:
#
# The above copyright notice and this permission notice shall be
# included in all copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
# EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
# MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
# NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
# LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
# OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
# WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
class Array
  def group_by
    inject([]) do |groups, element|
      value = yield(element)
      if (last_group = groups.last) && last_group.first == value
        last_group.last << element
      else
        groups << [value, [element]]
      end
      groups
    end
  end
end
