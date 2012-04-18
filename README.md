# testmore - Test::More for PHP

This is a PHP implementation of <a href="http://search.cpan.org/perldoc?Test::More">Test::More</a>.


## Usage

    plan('no_plan');
    # or
    plan(23);
    # or
    plan('skip_all');
    # or
    plan(array('skip_all' => $reason));

    require_ok('my_file.php');
    include_ok('another.php');

    # Various ways to say "ok"
    ok($got == $expected, $test_name);

    is  ($got, $expected, $test_name);
    isnt($got, $expected, $test_name);

    # Rather than echo "# here's what went wrong\n"
    diag("here's what went wrong");

    like  ($got, '/expected/', $test_name);
    unlike($got, '/expected/', $test_name);

    cmp_ok($got, '==', $expected, $test_name);

    is_deeply($got_complex_structure, $expected_complex_structure, $test_name);

    skip($why, $how_many);

    can_ok($module, $methods);
    isa_ok($object, $class);

    pass($test_name);
    fail($test_name);

    todo_begin("New frobaz feature");

    ok( $got, $expected, $test_name );
    # ...

    todo_end();

    # Or under 5.3
    todo( "New frobaz feature", function () {
        ok( $got, $expected, $test_name );
        # ...
    } );


## Testing the tests

If you have perl's <a href="http://search.cpan.org/dist/Test-Harness/">Test::Harness</a> installed (you almost certainly do), you can run the tests using:

    prove --exec 'php' test/test.php


## Credits

Originally inspired by work from Andy Lester. Written and  maintained by Chris Shiflett.

For contact information, see: http://shiflett.org/contact 
