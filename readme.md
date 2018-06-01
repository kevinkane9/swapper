# Project Setup

1. Fork the project repository to your GitHub account
1. Clone your forked repository to your local dev environment
1. Set the project repository as a remote named `upstream`:
    * `git remote add upstream git@github.com:sapperconsulting/sapper-suite.git`
1. Create a virtual host on your local environment
    * Hostname should be `www.sapperlocal.com` (you can make this resolve to your local environment by editing your hosts file)
    * Virtual host should be accessible on your local via HTTPS
    * These settings are due to pre-defined callback URLs in 3rd party APIs
1. Create an empty MySQL database
1. Copy & configure the following files from their sample versions:
    * `/phinx.yml`
    * `/conf/env.php`
1. Set phinx file permissions
    * If on a *nix:
        * `chmod 0777 vendor/bin/phinx`
        * `chmod 0777 vendor/robmorgan/phinx/bin/phinx`
    * If on Windows:
        * `chmod 0777 vendor\bin\phinx.bat`
        * `chmod 0777 vendor/robmorgan/phinx/bin/phinx`
1. Run db migrations from project root folder
    * On Linux: `vendor/bin/phinx migrate`
    * On Windows: `vendor\bin\phinx.bat migrate`
1. Good to go!

You can now login to the app using these credentials:

Email: `admin@sappersuite.com`

Pass: `s@ppeR312`

# SDLC

We are utilizing Visual Studio Team Services (VSTS) for feature / bug tracking, and will adhere to the following rules related to it:

1. Dev Tasks & Sapper Tasks are always children of a User Story or Bug
2. Dev Tasks & Sapper Tasks must always have original estimate (hours), completed work (hours), remaining work (hours).
3. Completed Work and Remaining work must be updated *Daily*
4. Original Estimates do not change after the Specify stage
5. Features are always children of Epics
6. User Stories and Bugs should be children of Features. If a Feature does not exist in the Epic, User Stories and Bugs must be children of the Epic
