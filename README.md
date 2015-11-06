# Functional test training

This is the sample code used in a training about functional testing in PHP, specifically for Symfony2 framework,
but it is easily applicable to any other framework, or even for plain PHP. It is based on my own —and short— experience
on testing, so, if anyone has any suggestion, it is welcomed.

Some of the code and configuration used here can be reused for other projects.

========================

## Sections covered in training

1. [General information about testing.](#general-information-about-testing)
2. [Some good practices to take into account in testing.](#some-good-practices-to-take-into-account-in-testing)
3. [PHPUnit basic usage:](#phpunit-basic-usage)
    1. [Simple usage.](#simple-usage)
    2. [Executing only a test file.](#executing-only-a-test-file)
    3. [Executing only a method of a test file.](#executing-only-a-method-of-a-test-file)
    4. [Generating code coverage.](#generating-code-coverage)
4. [Concrete examples of usage.](#concrete-examples-of-usage)
    1. [Normal testing.](#normal-testing)
    2. [New features.](#new-features)
    3. [Bugs.](#bugs)
    4. [Specification changes.](#specification-changes)

========================

## General information about testing

I am not gonna talk here about the convenience of testing and its importance in any software development. If someone
is interested, there is a great explanation about it in [Django documentation][1].

I will write a small remark, though: the difference between _functional testing_ and _unit testing_. Naively, _unit
testing_ only tests a small part of an application, typically a method within a class or similar. _Functional 
testing_, on the other side, is meant to test the logic of a complete application. Imagine a REST API, for example:
_unit testing_ may be used to test the concrete method that adds a user information to the database and generates some
data, whereas _functional testing_ may be used to test the complete process of updating of an user with an API call.

And remember, as —supposedly— Edsger W. Dijkstra said, «Program testing can be used to show the presence of bugs,
but never to show their absence!».

========================

## Some good practices to take into account in testing

I will describe a few of what I think are good practices to follow when writing functional tests:
- Always use `assertEquals`: it helps to keep your testing code clean; you are checking for an equality, that it is 
easier to understand; and you construct the logic of what must be tested, so it is easier to switch between different
testing utilities.
- Write as many tests as you can: some people might say that you are writing irrelevant tests, but it is really
cheap to write —or to copy— as many asserts as you want, so do it.
- Execute all your tests before deploying to production server: this way you will be sure that everything works
as intended.
- Write your tests when you are developing: do not wait until the whole application is finished, because in that case
you will not write them: it will be a tedious task, and you will not remember all features implemented. Write
them as you develop.
- Write at least a simple test to check that everything works as expected, i.e., the page is loading.
- It is a good practice in Symfony2 to have a test file for each controller, and within each one, a method for
each method defined in controller.
- [Symfony2 best practices for testing.][2]

========================

## PHPUnit basic usage

I will describe here how to use PHPUnit for this concrete project, using the most common options.

### Simple usage

This method executes all tests of all bundles of the application:

```bash
$ vendor/phpunit/phpunit/phpunit -c app/
```

Take into account that, as your application grows, testing time will also increase, so you will want to use any
of the following methods to test only those parts that you are interested in when developing or fixing a bug.

### Executing only a test file

This method executes all methods of a concrete php file:

```bash
$ vendor/phpunit/phpunit/phpunit -c app/ src/rubenrubiob/WebBundle/Tests/Controller/PoemControllerTest.php 
```

### Executing only a method of a test file

This method executes only the filtered method of a concrete php file. It is useful when you are developing a new feature
and you are only interested in testing that feature.

```bash
$ vendor/phpunit/phpunit/phpunit -c app/ --filter="testAll" src/rubenrubiob/WebBundle/Tests/Controller/PoemControllerTest.php
```



### Generating code coverage

Additionally, you can generate a code coverage report in different formats for each method described.
For example, to generate it in HTML format for the whole project (note that it generates it to a folder): 

```bash
$ vendor/phpunit/phpunit/phpunit -c app/ --coverage-html ../report/
```


========================

## Concrete examples of usage

The project is pretty simple: it only has two entities, _Author_, that represents an author and consists of a name; and
_Poem_, that represents a poem, with a title and an author related. Those are included in the `PoemBundle` bundle.
 
The application consists of a web page on one side, shipped in the `WebBundle` bundle; and of a webservice, shipped
in the `WebserviceBundle` bundle. This way, we are able to have tests for the two main development projects used
nowadays. Both features show a list of poems' titles and the author name of each one.

There are some external bundles used in this application:
- [`JMSSerializerBundle`][3]: in order to serialize the data for the webservice part.
- [`DoctrineFixturesBundle`][4]: in order to load some testing data. Fixtures are located
in `src/rubenrubiob/PoemBundle/DataFixtures/ORM/LoadPoemData.php` file.
- [`LiipFunctionalTestBundle`][5]: in order to have some helper classes. Furthermore, with this bundle we can
execute tests to an isolated SQLite database.

We will see below the basic cases when you will have to write functional tests.


### Normal testing

The code for this section is on the `master` branch.

This case is the normal one, when you are developing an application and you are writing its tests accordingly, either
before writing the actual code ([test-driven development][6]) or after, that is up to you.

We can consider this as a base of the application, and after achieving this status, you will work over it. You can
check the code for the functional tests of the application in the
`src/rubenrubiob/WebBundle/Tests/Controller/PoemControllerTest.php` file for the web page part, or in the
`src/rubenrubiob/WebserviceBundle/Tests/Controller/PoemControllerTest.php` file for the webservice part. Note that
for the web part we use the [Symfony2 DOM Crawler Component][7] to check the elements of the page, and for the
webservice part, as it returns a JSON, we are testing to an array.


### New features

The code for this section is on the `new-features` branch, so you can check it out.

Imagine that, once you have finished you application, the client —or your boss, or the project manager...— asks you
to add a new feature, for example, the publishing year of a poem. Developer must be committed to testing;
therefore, you _must_ write some more tests in order to accomplish the new features. Think that, if you write your
tests at the beginning of the implementation but you do not write any more tests in the future to match the
changes, the tests you wrote will become useless and all the time you inverted writing them will be wasted. That is
the reason that makes important for a developer to be committed to testing.

So, in order to match the new specification, you add more tests to the existing ones.


### Bugs

The code for this section is on the `bugs` branch, so you can check it out.

It is unavoidable that there are some bugs in your code that your tests did not detect, so the first thing you must do
is to write some asserts that expose those previously-undetected bugs, so they make the tests fail. Then, you make
all changes required in the code until all tests are passed correctly. You _must_ follow this process, so you are sure
in the future that the bug is completely fixed.

In this example, imagine that, for the web part, we showed another item in the list that should not have been there; 
and for the webservice part, we are serializing a property that we did not have to. The status of the code in this
branch is at this point, with bugs and with the tests to detect them written, so if you try to execute them, they will
fail.

Fortunately, changes necessary to pass all tests are easy to make:
- In file `src/rubenrubiob/WebBundle/Resources/views/Poem/all.html.twig`, remove lines 19-21.
- In file `src/rubenrubiob/PoemBundle/Entity/Poem.php`, remove lines 103-113.

Once you have done those changes, execute the tests again and you will see that they will pass.


### Specification changes

The code for this section is on the `specification-changes` branch, so you can check it out.

It should not be like that, but sometimes the specifications of the applications change during its development (or 
after) so it is important to make the changes to your test in order to match the changes to the specification.

So, the situation differs from the one of the previous subsection, but the steps to follow are the same: expose the
change, making tests fail, and change your code in order to match the new specification, passing the tests.

In this example we suppose that, for the web section, instead of using the CSS class _author-name_ we need to use
the class _artist-name_; and, for the webservice section, the author must come as artist, so the position of the
array will be different. The status of the code in this branch is at this point, with the tests written but failing.

The changes necessary to pass the tests are the following:
- In file `src/rubenrubiob/WebBundle/Resources/views/Poem/all.html.twig`, change _author-name_ by _artist-name_ in
line 16.
- In file `src/rubenrubiob/PoemBundle/Entity/Poem.php`, change _author_ by _artist_ in line 42.

Once you have changed the code, execute the tests and they will pass.






[1]:  https://docs.djangoproject.com/en/1.8/intro/tutorial05/
[2]:  http://symfony.com/doc/current/best_practices/tests.html
[3]:  http://jmsyst.com/bundles/JMSSerializerBundle
[4]:  http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
[5]:  https://github.com/liip/LiipFunctionalTestBundle
[6]:  https://en.wikipedia.org/wiki/Test-driven_development
[7]:  http://symfony.com/doc/current/components/dom_crawler.html