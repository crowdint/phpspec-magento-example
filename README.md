# CrowdPHPSpecTraining

At Crowd Interactive, we are interested in testing all our code and Magento is not the exception. We are implementing the [MageTest/MageSpec](http://tinyurl.com/nednm2x) Module based on [PHPSpec](http://tinyurl.com/q6xqvgo) toolset.

In this implementation, we have two different tests taken from the [Magecasts](http://tinyurl.com/qxs5ux8) tutorials. The first one is to understand how PHPSpec works and the second is to show how MageSpec works.

## First Test

"We will look at PHPspec and how we can use it to enhance our development workflow".

### Prerequisites

    PHP 5.3.x or greater
    Install composer

### Getting Started

#### Create composer.json file

On root project, create composer.json file with the data below:

```json
{
	"require-dev": {
		"phpspec/phpspec": "~2.1"
	},
	"config": {
		"bin-dir": "bin"
	},
    "autoload": {
        "psr-0": {
             "Crowd\\Store": "src"
         }
    }
}
```

#### Run composer install

    $ composer install

You will get something like this:

```bash
Loading composer repositories with package information
Installing dependencies (including require-dev)
  - Installing doctrine/instantiator (1.0.5)
    Loading from cache

  - Installing symfony/yaml (v2.7.2)
    Loading from cache

  - Installing symfony/process (v2.7.2)
    Loading from cache

  - Installing symfony/finder (v2.7.2)
    Loading from cache

  - Installing symfony/event-dispatcher (v2.7.2)
    Loading from cache

  - Installing symfony/console (v2.7.2)
    Loading from cache

  - Installing sebastian/recursion-context (1.0.0)
    Loading from cache

  - Installing sebastian/exporter (1.2.0)
    Loading from cache

  - Installing phpspec/php-diff (v1.0.2)
    Loading from cache

  - Installing sebastian/diff (1.3.0)
    Loading from cache

  - Installing sebastian/comparator (1.1.1)
    Loading from cache

  - Installing phpdocumentor/reflection-docblock (2.0.4)
    Loading from cache

  - Installing phpspec/prophecy (v1.4.1)
    Loading from cache

  - Installing phpspec/phpspec (2.2.1)
    Loading from cache

symfony/event-dispatcher suggests installing symfony/dependency-injection ()
symfony/event-dispatcher suggests installing symfony/http-kernel ()
symfony/console suggests installing psr/log (For using the console logger)
phpdocumentor/reflection-docblock suggests installing dflydev/markdown (~1.0)
phpdocumentor/reflection-docblock suggests installing erusev/parsedown (~1.0)
phpspec/phpspec suggests installing phpspec/nyan-formatters (~1.0 – Adds Nyan formatters)
```

#### PHPSpec run command

Now that we have bin/ and vendor/ directory in our project, let's go with this:

    $ bin/phpsepc run

And you will see:

```bash
0 specs
0 examples
0ms
```

### Play with MageSpec and PHPSpec

    $ bin/phpspec describe Crowd/Store/Product

Will return this message:

```bash
Specification for Crowd\Store\Product created in [rootproject]/spec/Crowd/Store/ProductSpec.php
```

In your folder project now you will see

![spec folder]
(http://i.imgur.com/p9uu1TX.png)

The content of the ProductSpec.php created file looks like this:

```php
<?php

namespace spec\Crowd\Store;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crowd\Store\Product');
    }
}
```

    $ bin/phpspec run

And now you will see this:

![class does not exists]
(http://i.imgur.com/0iZ7OV5.png)

Obviously you type YES and you will get the next message:

![class was created]
(http://i.imgur.com/r4oTSWn.png)

And the next file structure in your project

![src file structure]
(http://i.imgur.com/4DAdc3t.png)

Inside Product.php you will see

```php
<?php

namespace Crowd\Store;

class Product
{
}
```

Now inside [rootproject]/spec/Crowd/Store/ProductSpec.php file, write the next functions

```php
function it_should_have_a_name()
{
    $this->getName()->shouldReturn('Testing Spec');
}

function it_should_have_sku()
{
    $this->getSku()->shouldReturn('12345');
}
```

The complete files looks like:

```php
<?php

namespace spec\Crowd\Store;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crowd\Store\Product');
    }

    function it_should_have_a_name()
    {
        $this->getName()->shouldReturn('Testing Spec');
    }

    function it_should_have_sku()
    {
        $this->getSku()->shouldReturn('12345');
    }
}
```

What are we doing here? Well, we are defining two more test functions, one to check if a function called getName() returns a string with value "Testing Spec" and other to check if a function called getSku() returns a string with value "12345"

On terminal lets do:

    $ bin/phpspec run

It will display:

![getName() function does not exists]
(http://i.imgur.com/aT7yySp.png)

Press Y + return key:

![getSku() function does not exists]
(http://i.imgur.com/6KUmIbi.png)

Press Y + return key again:

![functions exists but tests does not pass]
(http://i.imgur.com/eOieqj8.png)

What does this mean? First of all, PHPSpec checks if getName() and getSku() functions exists in the Product class, and if it does not find them, asks us if we want to crete them. Once created, PHPSpec will try to run the tests, but they do not pass.

The Product.php file under [rootproject]/src/Crowd/Store/ changed its content and now looks like:

```php
<?php

namespace Crowd\Store;

class Product
{

    public function getName()
    {
        // TODO: write logic here
    }

    public function getSku()
    {
        // TODO: write logic here
    }
}
```

That's the reason of out tests not passing: the functions exist, but they do nothing. Lets work with them and type the following in Product.php

```php
<?php

namespace Crowd\Store;

class Product
{

    protected $_name;
    protected $_sku;

    public function __construct($name = '', $sku = '')
    {
        $this->_name    = $name;
        $this->_sku     = $sku;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getSku()
    {
        return $this->_sku;
    }
}
```

Run the specs again:

    $ bin/phpspec run

And... oh!, they don't pass again. Why?

![test not pass again]
(http://i.imgur.com/4ODyU1i.png)

This happened because phpspec is running without any init data. To do that, let's type the following inside ProductSpec class:

```php
function let()
{
    $name   = "Testing Spec";
    $sku    = "12345";
    $this->beConstructedWith($name, $sku);
}
```

The let() method is used to pass data into the constructor each time the parser gets created using the beConstructedWith() method

Now on the console, type once again

    $ bin/phpspec run

![test pass]
(http://i.imgur.com/YEOFaUC.png)

And we did it, friends!.

## Second Test

In this case we are going to show how you can test your Magento modules using [MageSpec](http://tinyurl.com/nednm2x)

We are going to need a Magento installation inside of our root project.

### Getting Started

#### Update composer.json

We have to update our composer.json file with the below data

```json
{
	"require-dev": {
		"psy/psysh": "@stable",
        "magetest/magento-phpspec-extension": "~2.0"
	},
	"config": {
		"bin-dir": "bin"
	},
    "autoload": {
        "psr-0": {
             "": [
                "magento/app",
                "magento/app/code/local",
                "magento/app/code/community",
                "magento/app/code/core",
                "magento/lib"
             ]
         }
    },
    "minimum-stability": "dev"
}
```

That json file contains the following changes: 

<ol>
	<li>The require dev modules are "psy/psysh" and "magetest/magento-phpspec-extension" intead of "phpspec/phpspec".</li>
	<li>The autoload field is used to load all the Magento files. As you see, a Magento installation called "magento" exist inside our root project.</li>
</ol>

After type on terminal this

    $ composer update

### The configuration file

Once composer update all the dependecies we have to create a configuration file called phpspec.yml in our root folder, this file will be used for PHPSpec to load the Magento Extension, the contains of this file is:

```yml
extensions: [MageTest\PhpSpec\MagentoExtension\Extension]
mage_locator:
  spec_prefix: 'spec'
  src_path: 'magento/app/code'
  spec_path: 'spec/app/code'
  code_pool: 'local'
```

What the file structure means?

- [extensions]: Who is the extension required
- [src_path]: The path to store the generated classes. MageSpec creates the directories if they do not exist.
- [spec_path]: The path of the specifications.
- [code_pool]: The code pool to store the Magento module.

Now we can run the following command:

    $ bin/phpspec

And you will see something like this:

![bin/phpspec with MageSpec](http://i.imgur.com/GZyJn4v.png)

### Let's play with MageSpec

As you see in the picture above there are some commands availables to work with PHPSpec, but also MageSpec has some useful description paramaters for the purposes of Magento.

We are going to work with the describe:block command. Then below we type on terminal:

    $ bin/phpspec describe:block crowd_helloworld/message

It should generate the following:

```bash
Specification for Crowd_Helloworld_Block_Message created in [rootproject]spec/app/code/local/Crowd/Helloworld/Block/MessageSpec.php.
```

And you spec folder will look like:

![spec local folder](http://i.imgur.com/BNac1nt.png)

The MessageSpec.php file contains:

```php
<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Crowd_Helloworld_Block_MessageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crowd_Helloworld_Block_Message');
    }
}
```

Now, type on terminal:

    $ bin/phpspec run

You will see a message like this:

![no class exist](http://i.imgur.com/eX1wQQb.png)

Just as in the previous article, the message above occurs becouse the class does not exist, and MageSpec ask us if we wanto to creat it. Type yes of course and you will see a message like this:

![helloworld_message class does not exist](http://i.imgur.com/DO7ao4a.png)

Now inside your magento/app/ folder the following structure exist:

![local app folders](http://i.imgur.com/wYRmkVH.png)

The contain of the files creted are:

###### config.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<config>
    <modules>
        <Crowd_Helloworld>
            <version>0.1.0</version>
        </Crowd_Helloworld>
    </modules>
    <global>
        <blocks>
            <crowd_helloworld>
                <class>Crowd_Helloworld_Block</class>
            </crowd_helloworld>
        </blocks>
    </global>
</config>
```

###### Message.php
```php
<?php

class Crowd_Helloworld_Block_Message extends Mage_Core_Block_Abstract
{

}
```

This is very great, becouse it also create for us the configuration structure for a Magento module with a blocks class declaration, in this case by the "describe:block" command.

Inside of [rootproject]/spec/app/code/local/Crowd/Helloworld/Block/MessageSpec.php type the following method to catch a message thtat returns frome the message() method in the Crowd_Helloworld_Block_Message class:

```php
function it_should_tell_you_that_you_must_be_registered(){
	$this->message()->shouldReturn('Hello guest, Please register with us for special offers');
}
```

Complete file looks like:

```php
<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Crowd_Helloworld_Block_MessageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crowd_Helloworld_Block_Message');
    }

    function it_should_tell_you_that_you_must_be_registered(){
        $this->message()->shouldReturn('Hello guest, Please register with us for special offers');
    }
}
```
