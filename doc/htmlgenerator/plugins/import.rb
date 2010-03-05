# Rake tasks for importing blog entries from feeds.
#--
# Copyright 2007 Suraj N. Kurapati
# See the file named LICENSE for details.

require 'time'
require 'cgi'
require 'yaml'

IMPORT_DIR = 'import'
directory IMPORT_DIR

desc "Import blog entries from RSS feed on STDIN."
task :import_rss => IMPORT_DIR do
  require 'cgi'
  require 'rexml/document'

  REXML::Document.new(STDIN.read).each_element '//item' do |src|
    name = CGI.unescapeHTML src.elements['title'].text.to_s
    date = Time.parse(src.elements['pubDate'].text.to_s) rescue Time.now
    tags = src.get_elements('category').map {|e| e.text.to_s } rescue []
    body = CGI.unescapeHTML src.elements['description'].text.to_s
    from = CGI.unescape src.elements['link'].text.to_s

    dstFile = make_file_name('.yaml', date.strftime('%F'), name)
    dst = File.join(IMPORT_DIR, dstFile)

    entry = %w[from name date tags].
      map {|var| {var => eval(var)}.to_yaml.sub(/^---\s*$/, '')}.
      join << "\nbody: |\n#{body.gsub(/^/, '  ')}"

    notify :import, dst
    File.write dst, entry
  end
end
