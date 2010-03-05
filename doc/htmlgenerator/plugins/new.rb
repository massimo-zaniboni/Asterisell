# Provides a Rake task to facilitate "Lazy Blogging" [1] where you
# can easily create a new blog entry source file without having to:
#
# * think of and manage unique file names every time
# * supply the current date and time
# * remember the entire syntax of a blog entry file
# * remember the names of all tags you have used thus far
#
# The name of the created file follows this format:
#
#   "entries/{today's date}+{serial number}.yaml"
#
# To create a new blog entry file that is ready for editing:
#
#   rake new
#
# To override the default values of blog entry fields:
#
#   rake new name='hello world' date='2008 march 17' tags='foo,bar' body='hey!'
#
# To override the tags field (values must be separated by commas):
#
#   rake new tags='foo,bar,hello world'
#
# To override the default location of the created file:
#
#   rake new file='hello_world.yaml'
#
# [1] Josef 'Jupp' Schugt, "Lazy Blogging", 2008 March 16, available at
#     http://cip.physik.uni-bonn.de/~jupp/2008-03-16-lazy-blogging.html
#--
# Copyright 2008 Suraj N. Kurapati
# See the file named LICENSE for details.

require 'date'
require 'yaml'

desc "Create a new blog entry file for editing."
task :new do
  # determine serial number for the new blog entry file by
  # counting the number of entries that were written today
  today = Date.today

  serial = ENTRIES.select do |e|
    t = e.date # date & time when entry was written
    today === Date.civil(t.year, t.month, t.day)
  end.length + 1 # use natural numbers (1..N)

  # create the new blog entry file
  file = File.join('entries', ENV['file'] || "#{today}+#{serial}.yaml")
  raise "File #{file.inspect} already exists." if File.exist? file

  notify :create, file
  File.write file, [
    { 'name' => ENV['name'] || '...' },
    { 'date' => ENV['date'] || Time.now.rfc822 },
    { 'tags' =>
      if ENV.key? 'tags'
        ENV['tags'].split(/\s*,\s*/)
      else
        # provide a list of every tag used thus far
        ENTRIES.map {|e| e.tags.map {|t| t.name } }.flatten.uniq.sort
      end
    },
    { 'body' => (ENV['body'] || '...') << "\n" } # newline causes paragraph mode
  ].map {|x| x.to_yaml.split(/$/, 2)[1] }.join.lstrip
end

