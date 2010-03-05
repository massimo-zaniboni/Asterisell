# project information
#--
# Copyright 2006 Suraj N. Kurapati
# See the file named LICENSE for details.

Rassmalog = {
  :name     => 'Rassmalog',
  :version  => '12.0.1',
  :release  => '2008-08-01',
  :website  => 'http://rassmalog.rubyforge.org'
}

class << Rassmalog
  # Returns the name and version of Rassmalog.
  def to_s
    self[:name] + ' ' + self[:version]
  end

  # Returns a hyperlink containing the name and version of Rassmalog.
  def to_link
    link self[:website], to_s
  end

  # throw an exception instead of returning nil
  alias [] fetch
end
