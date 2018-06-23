<?php
require(dirname(__FILE__)."/../init.php");

class Home extends Site{
	private $pages = array(
		1 => array(
			1 => 'yoda.png',
			2 => 'Occured, a 404 error has...',
			3 => 'Lost a page I have. How embarrassing...',
			4 => 'The dark side I sense in you. Due to a disturbance in the force I couldn\'t find the page you were looking for. <br /><br />
				Trust in the force, clear your mind, unlearn what you have learned, and find your missing page you will. Alternatively you could just return to the <a href="http://legacy-logs.com/">homepage</a>.<br /><br />
				If this page exist should, <a href="{path}/Service/Contact">contact the High Council</a> you must. They help you can, I\'m sure.<br /><br />
				Remember, a Jedi\'s strength flows from the Force. But beware anger, fear, aggression. The dark side are they. Once you start down the dark path, forever will it dominate your destiny.'
		),
		2 => array(
			1 => "aptx.jpg",
			2 => "APTX-404",
			3 => "Maybe the page has shrunken to child",
			4 => 'Pssssssssst, if you are reading this you have probably stumbled over suspicious activities of the black organization. <br /><br />
				Don\'t make any noice, if they find you, they will probably do the same to you as they did to this page. Quickly, <a href="http://legacy-logs.com/">get away</a> from here, as long as you still can. <br /><br />
				You are still here? Alright, go quickly and <a href="{path}/Service/Contact">tell Shinoshi</a> about this. Together you might have a chance. <br /><br />
				Oh no, there is Rum and Gin and Vodka and Vermouth and Korn and Chi.....aaaaaaah'
		),
		3 => array(
			1 => "bart.jpg",
			2 => "I WILL NOT LOOSE A PAGE AGAIN. I WILL NOT...",
			3 => "SHIIINOO",
			4 => 'SHINO, how could you dare to loose a page again ?! <br /><br />
				As punishment you are going to write this sentence 100 times down and then you can go back to the <a href="http://legacy-logs.com/">homepage</a>. <br /><br />
				You did it again?! Okay, into my office! We are going to <a href="{path}/Service/Contact">call you parents</a> now and discuss this matter!<br /><br />
				What did you say, I have something on my jacket? Huh, where are you? SHINOOO!!!!!',
		),
		4 => array(
			1 => "404homer.png",
			2 => "404 PAGE NOT FOUND",
			3 => "DAMN IT WHERE ARE YOU?!",
			4 => 'Which button am I going to press now. HOW CAN I FIX THIS?! <br /><br />
				If Mr. Shino finds that out, I am going to loose my job. Huh, what is this "seeeeeeeeeeelf deeeeeee-struuuuuuc-tioooon". Can\'t be wrong. <a href=\"/\">*press*</a><br /><br />
				Ufff, that was close. If you pressed this button the whole website could have exploded. Quickly, <a href=\"/Service/Contact\">eat a donut</a>, maybe a solution will come to your mind. <br /><br />
				Hmmmm, strawberry....',
		),
		5 => array(
			1 => "catswhocode.jpg",
			2 => "404: But we are already working on it!",
			3 => "Its just a matter of time...",
			4 => 'Aaaaaaaaaawwwwwwwwwwwwwwwwww, CATS. SOOOOOOOOOOOOOO CUTEEEEEEEEEEEEE. No seriously, CATS ARE CUTE! <br /><br />
				Okay, once you understand this, you can continue to the <a href="http://legacy-logs.com/">homepage</a> again. <br /><br />
				You are still here. You want to discuss about this?! You don\'t? The website is not working? Why, didn\'t you <a href="{path}/Service/Contact">tell me</a>? <br /><br />
				Oh, is that a cat? aaaaaaawwww...',
		),
		6 => array(
			1 => "deadlink.png",
			2 => "404: Oh, it looks like you found a Dead Link",
			3 => "Maybe, you should just...",
			4 => 'Nah, seriously. Didn\'t your ma\' tell you not to touch things that lay on the ground? <br /><br />
				He is still so young. WHYYYY?! Who is going to save Zelda now?! Oh, maybe <a href=\"/\">you could</a>!<br /><br />
				Wait, if you did\'t go to save Zelda, and Link is laying there... Who is goi... *AAAAAAAAAAAAAAH* - Ok, maybe ask a <a href=\"/Service/Contact\">hero for aid</a>. <br /><br />
				Ooooooooooor, let\'s just wait for the respawn.'
		),
		7 => array(
			1 => "kaitokidcard.jpg",
			2 => "A KID CARD: 404?! KID STOLE OUR PAGE",
			3 => "I thought he just steals jewels?",
			4 => 'I can\'t believe Kid did that. He would never steal a page. Something has to be wrong! <br /><br />
				What you still think, Kid did this?! What are you doing, will you seriously hand him out to <a href="http://legacy-logs.com/">the police</a>? <br /><br />
				Uff, I am glad you did\'t do this after all. I knew I could trust you. Good that you <a href="{path}/Service/Contact">trusted me with the matter</a>. <br /><br />
				So let\'s see...'
		),
		8 => array(
			1 => "lookingforthepage.gif",
			2 => "404, 404, 404, 404, 404, 404",
			3 => 'Every page says this "404"...',
			4 => 'Okay, aha. I see. Okay...<br /><br />
				Oh, you still haven\'t left? Here is the <a href=\"/\">homepage</a>. <br /><br />
				You were looking for a specfic page? I have no clue where it is, but maybe <a href=\"/Service/Contact\">he can help</a> you.<br /><br />
				Cyaaa, around mate!'
		),
		9 => array(
			1 => "miesmuschel.jpg",
			2 => "Ooooh, holy mussel... Where is our beloved page",
			3 => "Ask me just once more...",
			4 => 'Ooooh, holy mussel... Where is our beloved page? - Yes *?????* <br /><br />
				Ooooh, holy mussel... Wheeeere is ouuuur beloveeeed pageeee?!. - No. *<a href=\"/\">Arrrrrg, screw this</a>* <br /><br />
				Ooooh, holy mussel... Where is.... ah, you know what? FUCK YOU. I am just going to <a href=\"/Service/Contact\">contact Shino</a>. He sure will know where it is. <br /><br />
				Why did I even try this?...'
		),
		10 => array(
			1 => "movealong.gif",
			2 => "This is not the page you were looking for...",
			3 => "Move along, move along...",
			4 => 'Can I see this page please? - ~This is not the page you are looking for...~ <br /><br />
				What do you think where we are ?! Star Wars?! Screw you, I will <a href=\"/\">find it myself</a>. <br /><br />
				Actually I am mediclorian. Jedi stuff like this doesn\'t work on me. So will you help me <a href=\"/Service/Contact\">finding the page</a> now already? <br /><br />
				*Jesus... always those roleplayers...*'
		),
		11 => array(
			1 => "notfound.jpg",
			2 => "404 NOT FOUND",
			3 => "Are you fu***** kidding me?!",
			4 => 'Alright... Calm down... Calm down... <br /><br />
				I will just return to the <a href=\"/\">homepage</a> now and try it again. <br /><br />
				Okay. I\'m starting to get mad. Let\'s <a href=\"/Service/Contact\">yell at Shino</a> a little... <br /><br />
				*Hey, ehm, Shino, you know this page...*'
		),
		12 => array(
			1 => "oops.jpg",
			2 => "Ooops, 404",
			3 => "Wrong Button...",
			4 => 'Okay. I guess let\'s try <a href=\"/\">this one</a> then... <br /><br />
				Still does\'t work huh? Okay. Let\'s yell at the <a href=\"/Service/Contact\">lousy programmer</a> responsible for this shieet! <br /><br />'
		),
		13 => array(
			1 => "somethingwentwrong.jpg",
			2 => "Something went wrong...",
			3 => "oops..",
			4 => 'I swear I didn\'t do this! Really it was... ehm... ehm... <br /><br />
				*Seeing Shino running by* - *Pointing at him* <br /><br />
				Right, he was it. I saw it! *<a href=\"/\">making "a move"</a>* <br /><br />
				Nah, nah, nah. You stay here and <a href=\"/Service/Contact\">explain this to me</a>. Veeeeeeeeery slowly, so that even I get it.'
		),
		14 => array(
			1 => "spongebob.jpg",
			2 => "404: GIVE ME THIS PAGE!",
			3 => "ehm Sir...",
			4 => 'Ehm sir. You are standing towards the wrong direction. *ooh* <br /><br />
				GIVE ME THIS PAGE! - private or company deposits? *<a href=\"/\">ehm, private</a>* <br /><br />
				Do you have any information about this page? Can I have your <a href=\"/Service/Contact\">bank card</a> please? <br /><br />
				Thank you.'
		),
		15 => array(
			1 => "truth-eye.jpg",
			2 => "404: Something went seriously wrong...",
			3 => "But, we just tried...",
			4 => 'Even for your beloved page. Not even alchemy can bring back the death... <br /><br />
				Everything in the world has an equivialent value. Besides life... You can <a href=\"/\">still go back</a>.<br /><br />
				Everyone will learn this lesson. Either the easy or the hard way. Still we need to <a href=\"/Service/Contact\">talk about it</a>...
				Even a philosopher\'s stone has a high price for its power...'
		),
		16 => array(
			1 => "whereisthepage.jpg",
			2 => "404: WHERE IS THE PAGE?!",
			3 => "I will not sleep until I find it!",
			4 => 'We will find the page... Right Teddy? <br /><br />
				Right Teddy... We will *oooaaaah* fin...d thi..s pageee *<a href="http://legacy-logs.com/">ZzzzzzzzzZzzzzzz</a>* <br /><br />
				Nope, I am awake. UNTIL I FIND THIS PAGE. <a href="{path}/Service/Contact">TEEEEDDYYYYYYYYYYYYYY?!</a> Hand it out! <br /<br />
				*Zzzzzzzzzzzzzzzzzz...*'
		)
	);
	
	public function content(){
		$num = rand(1,16);
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>'.$this->pages[$num][2].'</h1>
					<h2>'.$this->pages[$num][3].'</h2>
					<img src="{path}404/pics/'.$this->pages[$num][1].'" />
					<p>
						'.$this->pages[$num][4].'
					</p>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir){
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__);

?>