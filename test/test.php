<?
	$dir = dirname(__FILE__);
	include($dir.'/../testmore.php');

	class TestClass {
		function foo(){}
		function bar(){}
	}

	$test_obj = new TestClass();

	$struct_1 = array(
		1 => array(
			'foo' => 'bar',
		),
		'woo' => 'yay',
	);

	$struct_2 = array(
		1 => array(
			'foo' => 'baz',
		),
		'woo' => 'yay',
	);

	echo "1..32\n";


	#
	# these should pass
	#

	start_capture();

	ok(1, 'ok()');
	check_capture(true);

	is(2, 2, 'is()');
	check_capture(true);

	is("2", 2, 'is()');
	check_capture(true);

	isnt(2, 3, 'isnt()');
	check_capture(true);

	isnt(2, "3", 'isnt()');
	check_capture(true);

	like("foo", '!oo!', 'like()');
	check_capture(true);

	unlike("foo", '!oof!', 'unlike()');
	check_capture(true);

	cmp_ok(1, '==', 1, 'cmp_ok()');
	check_capture(true);

	cmp_ok(2, '>', 1, 'cmp_ok()');
	check_capture(true);

	cmp_ok(1, '<', 2, 'cmp_ok()');
	check_capture(true);

	can_ok($test_obj, array('foo', 'bar'), 'can_ok()');
	check_capture(true);

	isa_ok($test_obj, 'TestClass');
	check_capture(true);

	pass('pass()');
	check_capture(true);

	include_ok($dir.'/inc_true.php');
	check_capture(true);

	require_ok($dir.'/inc_true.php');
	check_capture(true);

	is_deeply($struct_1, $struct_1, 'is_deeply()');
	check_capture(true);


	#
	# Expecting these to fail
	#

	ok(0, 'ok()');
	check_capture(false);

	is(2, 3, 'is()');
	check_capture(false);

	is("2", 3, 'is()');
	check_capture(false);

	isnt(2, 2, 'isnt()');
	check_capture(false);

	isnt(2, "2", 'isnt()');
	check_capture(false);

	like("foo", '!oof!', 'like()');
	check_capture(false);

	unlike("foo", '!oo!', 'unlike()');
	check_capture(false);

	cmp_ok(1, '==', 2, 'cmp_ok()');
	check_capture(false);

	cmp_ok(1, '>', 2, 'cmp_ok()');
	check_capture(false);

	cmp_ok(2, '<', 1, 'cmp_ok()');
	check_capture(false);

	can_ok($test_obj, array('foo', 'bar', 'baz'));
	check_capture(false);

	isa_ok($test_obj, 'TestClass2');
	check_capture(false);

	fail('fail()');
	check_capture(false);

	include_ok($dir.'/inc_false.php');
	check_capture(false);

	require_ok($dir.'/inc_false.php');
	check_capture(false);

	is_deeply($struct_1, $struct_2, 'is_deeply()');
	check_capture(false);


	$GLOBALS['_no_plan'] = false;
	$GLOBALS['_num_failures'] = 0;

	if ($GLOBALS['_meta_failures']){
		$GLOBALS['_meta_tests']--;
		echo "# Looks like you failed {$GLOBALS['_meta_failures']} tests of {$GLOBALS['_meta_tests']}.\n";
	}


	function start_capture(){
		$GLOBALS['_meta_tests'] = 1;
		$GLOBALS['_meta_failures'] = 0;
		@ob_end_clean();
		ob_start();
	}

	function check_capture($pass){
		$out = @ob_get_contents();
		@ob_end_clean();
		$lines = explode("\n", $out);

		$results = array();

		foreach ($lines as $line){
			$line = trim($line);
			if (strlen($line) == 0) continue;
			if (substr($line, 0, 1) == '#') continue;

			if (preg_match('!^ok (\d+)( - (.*))?$!', $line, $m)){
				$results[$m[1]] = array(true, isset($m[3]) ? $m[3] : '');
			}

			if (preg_match('!^not ok (\d+)( - (.*))?$!', $line, $m)){
				$results[$m[1]] = array(false, isset($m[3]) ? $m[3] : '');
			}
		}

		$num = $GLOBALS['_meta_tests']++;

		if (count($results) == 0){
			echo "not ok $num - got no results\n";
		}
		if (count($results) > 1){
			echo "not ok $num - got too many results\n";
		}

		$result = array_pop($results);
		$explain = $result[1] ? " - $result[1]" : '';
		if ($pass){
			if ($result[0]){
				echo "ok $num - pass$explain\n";
			}else{
				echo "not ok $num - expected pass$explain\n";
				$GLOBALS['_meta_failures']++;
			}
		}else{
			if (!$result[0]){
				echo "ok $num - fail$explain\n";
			}else{
				echo "not ok $num - expected fail$explain\n";
				$GLOBALS['_meta_failures']++;
			}
		}

		ob_start();
	}
