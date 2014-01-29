class app::database {

  class { '::mysql::server' :
     root_password => 'password',
     databases => {
        'guestbook_demo' => {
          ensure => 'present',
          charset => 'utf8'
        }
     }
  }
  
}
