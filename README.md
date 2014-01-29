Demo Guestbook Application using Google OAuth2
==============================================

Introduction
------------
This is a demo application using Zend Framework 2 to build a guestbook 
(MySQL based) that uses Google OAuth2 to authenticate the user before allowing
a post. 

Usage
-----
You can try this demo yourself either locally or remotely on AWS using Vagrant as follows:

 - Modify VagrantConfig.json to suit your needs
 - Add a `config/autoload/local.php` to the application to set up the database (the `db` key) and the oauth2 client id/secret (the `oauth2` key)

You can then bring up the app as follows:

```
$ vagrant up
```

to bring up a local virtual machine running the code base (OAuth2 won't be enabled, just the guestbook features) or alternatively

```
$ export ENV=ec2
$ vagrant up --provider=aws
```

to bring up an EC2 instance running the code base (OAuth2 will function properly as long as you have the callbacks configured) 
