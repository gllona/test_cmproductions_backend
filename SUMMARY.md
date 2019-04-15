# Video importer tool

> A solution to the Kantox/CMProductions backend test
>
> Gorka Llona
>
> gllona@gmail.com 

First of all, greets to you Kantox / CMProductions team and thanks for the opportunity.

### Aim

The aim of this solution is to satisfy the requirement in a way that shows some features that could be
valued by you readers positively.

### Design notes

This is a simple CLI tools implemented with Laravel 5.8.

The code shows:

* How to use Laravel for implementation of CLI tools

* How to implement a simple Laravel Service Provider

* The SOLID Software Engineering approach

* SOLI[D]: The Inversion of Control (IoC) approach. At this moment there are two feed sources that are processed using a
  common algorithm: 
  
  1. parse the feed
  1. download the video
  1. save the obtained data
  
  This algorithm is implemented in a generic way in `Services\BaseFeedService` and each subclass 
  (one for glorf, one for flub)
  must implement three methods for the specifics of the parse, download and save

* [S]OLID: each class and method have a single responsibility

* SOL[I]D: interfaces are used when possible and stored in the `Contracts` directory

* Design patterns: Registry. `FeedsRegistry` associates the feed source `id` that is passed to the command
  to the specific service that should be used (`GlorfFeedService`, `FlubFeedService`). This can't be binded
  at bootstrap time (Service Container / Provider) because it depends on user input (command argument)

### Installation steps

This project was developed with the latest version of Laravel Homestead (v8.2.0).

1. `cd your/path/to/Homestead`
1. `vagrant ssh`
1. Clone the repo and `cd` to directory
1. `composer install`

### Repository

This code can be cloned from the following Github URL:

`https://github.com/gllona/test_cmproductions_backend.git`

### Test & run

Test:

* `phpunit`

Run:

* `bin/import glorf`
* `bin/import flub`

Pass `--details` or `-d` to the command to see the trace of the specific steps taken.
                                                                               
### If more time was available...

1. Document all public methods

Thanks!
