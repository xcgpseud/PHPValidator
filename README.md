# Validator

### This is currently a work in progress

> When using this, be sure to run `composer install` first.

The idea behind this is to enable some kind of validation
helper system whereby you can pass around functions
that run validation on the given target.

This enables you to turn large if statements in to something
easily readable and stop blocking up functions with huge
conditionals.

Example:

**From:**
```php
$array = [
    'firstName' => 'John',
    'lastName' => 'Doe',
    'age' => 23,
    'homeTown' => 'Bread Street',
];

if (
    !empty($array['firstName'] &&
    !empty($array['lastName'] &&
    !empty($array['age'] &&
    !empty($array['homeTown'] &&
    $age > 18
) {
    echo "I am over 18!";
} else {
    echo "I am either below 18 or not a person.";
}
```

**To:**
```php
$array = [
    'firstName' => 'John',
    'lastName' => 'Doe',
    'age' => 23,
    'homeTown' => 'Bread Street',
];

// This could be stored in some kind of helper, to fetch with less code
$v = new Validator();
$func = $v->add()
    ->withKeys(['firstName', 'lastName', 'age', 'homeTown']
    ->withAction('!empty')
    ->save()->getFunction();
    
// And then you just run it like so
if ($func($array) && $array['age'] > 18) {
    echo "I am over 18!";
} else {
    echo "I am either below 18 or not a person.";
}
```

### Things that are coming:

> The ability to specify keys / a key with a specific
action to run on only those keys

> The ability to add an "all keys" option that will
recursively run the action(s) on all of the keys
in an array

> Naming tidy-up: Currently, as it's WIP, the naming
of the methods are a bit shaky so it will eventually look
better

> A template helper method to return these functions,
as an example for real-world usage.