<?php
/*
Plugin Name: tweetrix
Plugin URI: http://wordpress.org/extend/plugins/tweetrix/
Description: a configurable twitter word cloud
Author: Oliver C Dodd
Version: 1.0.2
Author URI: http://01001111.net
  
  Copyright (c) 2009 Oliver C Dodd - http://01001111.net
  
  Much of the functionality is taken from the free 01001111 library
  http://01001111.net/01001111lib
  
  Permission is hereby granted,free of charge,to any person obtaining a 
  copy of this software and associated documentation files (the "Software"),
  to deal in the Software without restriction,including without limitation
  the rights to use,copy,modify,merge,publish,distribute,sublicense,
  and/or sell copies of the Software,and to permit persons to whom the 
  Software is furnished to do so,subject to the following conditions:
  
  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.
  
  THE SOFTWARE IS PROVIDED "AS IS",WITHOUT WARRANTY OF ANY KIND,EXPRESS OR
  IMPLIED,INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL 
  THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,DAMAGES OR OTHER
  LIABILITY,WHETHER IN AN ACTION OF CONTRACT,TORT OR OTHERWISE,ARISING
  FROM,OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
  DEALINGS IN THE SOFTWARE.
*/
class Tweetrix
{
	/*-VARIABLES----------------------------------------------------------*/
	public $options			= array(
		'user'			=> "twitterapi",
		'nTweets'		=> 200,
		'minRepetitions'	=> 1,
		'minWordLength'		=> 3,
		'wordFilter'		=> 'the be to of and a in that have i it for not on with he as you do at this but his by from they we say her she or an will my one all would there their what so up out if about who get which go me when make can like time no just him know take people into year your good some could them see other than then now look only come its over  think  also back after use two how our work first well way even new want because any these give day most us',
		'minFontSize'		=> .8,
		'maxFontSize'		=> 2,
		'deltaSize'		=> .2,
		'fontUnits'		=> "em",
		'filterUsernames'	=> true,
		'filterURLs'		=> true,
		'filterNumbers'		=> true,
		'title'			=> 'tweetrix',
		'divid'			=> 'tweetrix',
	);
	
	const ID			= 'Tweetrix';
	
	/*-CONSTRUCT----------------------------------------------------------*/
	//public function __construct($params)
	public function Tweetrix()
	{
		$params = $this->getOptions();
		foreach ($params as $k => $v)
			$this->options[$k] = $v;
		foreach ($this->options as $k => $v)
			$this->$k = $v;
	}
	/*-OUPUT--------------------------------------------------------------*/
	public function output()
	{
	?>
		<script type="text/javascript">
		/* Tweetrix.js - http://01001111.net/01001111lib */
		Tweetrix=function(a){this.applyOptions=function(d,c){d=d||{};for(var b in c){this[b]=(d[b]==undefined)?c[b]:d[b]}};this.applyOptions(a,{type:"public",user:"twitterapi",searchTerm:"null",limit:200,minSize:0.8,maxSize:2,deltaSize:0.2,sizeUnits:"em",minCount:0,minWordLength:3,filterUsernames:true,filterURLs:true,filterNumbers:true});this.tweets=[];this.words=[];this.wordsCounted={};this.callback=function(){}};Tweetrix.commonWords="the be to of and a in that have i it for not on with he as you do at this but his by from they we say her she or an will my one all would there their what so up out if about who get which go me when make can like time no just him know take people into year your good some could them see other than then now look only come its over  think  also back after use two how our work first well way even new want because any these give day most us";Tweetrix.prototype={REST_URL:"http://twitter.com/statuses/",SEARCH_URL:"http://search.twitter.com/search",PUBLIC_TIMELINE:"public_timeline",USER_TIMELINE:"user_timeline",ATOM:"atom",JSON:"json",RSS:"rss",XML:"xml",urlRegEx:/http:\/\/[\S]+/ig,userReplyRegEx:/@[\S]+/g,user:"twitterapi",count:20,grabCount:20,grabbed:0,page:1,excludeReplies:true,callback:null,tweets:null,words:null,wordsCounted:null,userURL:function(a,b,c){if(b==undefined){b=this.json}if(c==undefined){c=false}return this.REST_URL+this.USER_TIMELINE+"/"+a+"."+b+(c?"?"+this.queryString(c):"")},publicURL:function(a,b){if(a==undefined){a=this.json}if(b==undefined){b=false}return this.REST_URL+this.PUBLIC_TIMELINE+"."+a+(b?"?"+this.queryString(b):"")},queryString:function(b){if(!Tweetrix.isOfType(b,"Object")){return b}var c=[];for(var a in b){c.push(encodeURIComponent(a)+"="+encodeURIComponent(b[a]))}return c.join("&")},request:function(a,d){var c="twitterCallback"+Math.floor(1000000000*Math.random());window[c]=function(e){d(e)};a+=((a.indexOf("?")==-1)?"?":"&")+"callback="+c;var b=document.createElement("script");b.setAttribute("type","text/javascript",0);b.setAttribute("src",a,0);document.body.appendChild(b)},processParams:function(b){for(var a in b){this[a]=b[a]}},latestNFor:function(d,c,b){this.callback=d;this.count=(c!=undefined)?c:1;if(b!=undefined){this.processParams(b)}var a=this.userURL(this.user,this.JSON,{page:this.page});this.request(a,this.bind(this.processLatestNFor))},processLatestNFor:function(a){if(!Tweetrix.isOfType(a,"Array")||!a.length){return this.callback(this.tweets)}for(var b=0;b<a.length;b++){if(this.excludeReplies&&a[b]["in_reply_to_user_id"]){continue}this.tweets[this.tweets.length]=a[b];if(this.tweets.length>=this.count){return this.callback(this.tweets)}}this.page++;this.latestNFor(this.callback,this.count)},wordCount:function(c,b){this.callback=c;this.count=b;this.grabCount=this.count==undefined?this.limit:this.count;var a=this.userURL(this.user,this.JSON,{page:this.page,count:this.grabCount});this.request(a,this.bind(this.processWordCount))},processWordCount:function(a){var d=[];if(!Tweetrix.isOfType(a,"Array")||!a.length){return this.countWords(this.callback)}for(var c=0;c<a.length;c++){this.grabbed++;d=this.processWords(a[c].text);if(!d){continue}for(var b=0;b<d.length;b++){this.words.push(d[b])}}if((a.length<this.grabCount)||(this.grabbed>=this.count)){return this.countWords(this.callback)}this.page++;this.wordCount(this.callback,this.count)},processWords:function(a){if(a==undefined){return[]}if(this.filterURLs){a=a.replace(this.urlRegEx,"")}if(this.filterUsernames){a=a.replace(this.userReplyRegEx,"")}return a.toLowerCase().match(/[\w-']+/g)},countWords:function(b){this.words.sort();for(var a=0;a<this.words.length;a++){if(this.wordsCounted[this.words[a]]!=undefined){this.wordsCounted[this.words[a]]++}else{this.wordsCounted[this.words[a]]=1}}this.callback(this.wordsCounted)},buzzWords:function(c,a){this.callback=c;this.count=20;this.grabCount=20;var b=this.publicURL(this.JSON);this.request(b,this.bind(this.processWordCount))},bind:function(a){var b=this;return function(){return a.apply(b,arguments)}},cloud:function(a){this.wordCount(this.bind(function(j){var h="";var e=Tweetrix.commonWords.split(" ");for(var d in j){if(j[d]<this.minCount){continue}if(d.length<this.minWordLength){continue}if(this.filterNumbers&&!isNaN(Number(d))){continue}var g=e.search(d);if(g<0){var c="";var f=this.minSize+this.deltaSize*(j[d]-this.minCount);if(f>this.maxSize){f=this.maxSize;c="font-weight:bold;"}h+=" <span style='font-size:"+f+this.sizeUnits+";"+c+"' title='"+j[d]+"'>"+d+"</span> "}else{delete e[g]}}a(h)}),this.limit)}};Tweetrix.isOfType=function(b,a){return Object.prototype.toString.call(b)=="[object "+a+"]"};Array.prototype.search=function(a){for(var b=0;b<this.length;b++){if(this[b]==a){return b}}return -1};
		</script>
		<div id="<?php echo $this->divid ?>"></div>
		<script type="text/javascript">
			var t = new Tweetrix({
				type:"user",
				user:"<?php echo $this->user ?>",
				limit:<?php echo $this->nTweets ?>,
				minCount:<?php echo $this->minRepetitions ?>,
				minWordLength:<?php echo $this->minWordLength ?>,
				minSize:<?php echo $this->minFontSize ?>,
				maxSize:<?php echo $this->maxFontSize ?>,
				deltaSize:<?php echo $this->deltaSize ?>,
				sizeUnits:"<?php echo $this->fontUnits ?>",
				filterUsernames:<?php echo $this->filterUsernames ? "true" : "false" ?>,
				filterURLs:<?php echo $this->filterURLs ? "true" : "false" ?>,
				filterNumbers:<?php echo $this->filterNumbers ? "true" : "false" ?>
			});
			Tweetrix.commonWords = "<?php echo $this->wordFilter; ?>"
			t.cloud(function(s) { document.getElementById("<?php echo $this->divid ?>").innerHTML = s; });
		</script>
	<?php
	}
	
	public function getOptions()
	{
		return !($options = get_option(Tweetrix::ID))
			? $this->options
			: $options;
	}
}
/*-OPTIONS--------------------------------------------------------------------*/
function tweetrix_number($n,$min=null,$max=null) {
	$n += 0;
	if ($min != null && $n < $min)
		$n = $min;
	if ($max != null && $n > $max)
		$n = $max;
	return $n;
}

/*-GET OPTIONS--------------------------------------------------------*/
function widget_Tweetrix_options()
{
	$t = new Tweetrix();
	$options = $t->getOptions();
	if($_POST['Tweetrix-submit'])
	{
		$options = array(
			'user'			=> $_POST['Tweetrix-user'],
			'nTweets'		=> $_POST['Tweetrix-nTweets'],
			'minRepetitions'	=> $_POST['Tweetrix-minRepetitions'],
			'minWordLength'		=> $_POST['Tweetrix-minWordLength'],
			'wordFilter'		=> $_POST['Tweetrix-wordFilter'],
			'minFontSize'		=> $_POST['Tweetrix-minFontSize'],
			'maxFontSize'		=> $_POST['Tweetrix-maxFontSize'],
			'deltaSize'		=> $_POST['Tweetrix-deltaSize'],
			'fontUnits'		=> $_POST['Tweetrix-fontUnits'],
			'filterUsernames'	=> $_POST['Tweetrix-filterUsernames'],
			'filterURLs'		=> $_POST['Tweetrix-filterURLs'],
			'filterNumbers'		=> $_POST['Tweetrix-filterNumbers'],
			'title'			=> $_POST['Tweetrix-title'],
			'divid'			=> $_POST['Tweetrix-divid']);
		// validation
		$options['nTweets']		= tweetrix_number($options['nTweets'],0,200);
		$options['minWordLength']	= tweetrix_number($options['minWordLength'],0);
		$options['minRepetitions']	= tweetrix_number($options['minRepetitions'],0);
		$options['minFontSize']		= tweetrix_number($options['minFontSize'],0);
		$options['maxFontSize']		= tweetrix_number($options['maxFontSize'],0);
		$options['deltaSize']		= tweetrix_number($options['deltaSize'],0);
		update_option(Tweetrix::ID,$options);
	}
	?>
	<p>	Twitter User:
		<input	type="text" name="Tweetrix-user" value="<?php echo $options['user']; ?>"  />
	</p>
	<p>	Number of Tweets to use (max 200):
		<input	type="text" name="Tweetrix-nTweets" size="5" value="<?php echo $options['nTweets']; ?>"  />
	</p>
	<p>	Minimum Word Repetitions:
		<input	type="text" name="Tweetrix-minRepetitions" size="5" value="<?php echo $options['minRepetitions']; ?>"  />
	</p>
	<p>	Minimum Word Length:
		<input	type="text" name="Tweetrix-minWordLength" size="5" value="<?php echo $options['minWordLength']; ?>"  />
	</p>
	<p>	Filter Words (seperated by spaces):<br />
		<textarea name="Tweetrix-wordFilter" cols="20" rows="20"><?php echo $options['wordFilter']; ?></textarea>
	</p>
	<p>	Minimum Font Size:
		<input	type="text" name="Tweetrix-minFontSize" size="5" value="<?php echo $options['minFontSize']; ?>"  />
	</p>
	<p>	Maximum Font Size:
		<input	type="text" name="Tweetrix-maxFontSize" size="5" value="<?php echo $options['maxFontSize']; ?>"  />
	</p>
	<p>	Font Size Delta (change in font size for every additional occurence of a word):
		<input	type="text" name="Tweetrix-deltaSize" size="5"  value="<?php echo $options['deltaSize']; ?>"  />
	</p>
	<p>	Font Units:
		<select	name="Tweetrix-fontUnits"><options><option>em</option><option>pt</option><option>px</option></options></select>
	</p>
	<p>	Filter Usernames?
		<input type="hidden" name="Tweetrix-filterUsernames" value="0" />
		<input type="checkbox" name="Tweetrix-filterUsernames" value="1" <?php echo $options['filterUsernames'] ? "checked='checked'" : ""; ?> />
	</p>
	<p>	Filter URLs?
		<input type="hidden" name="Tweetrix-filterURLs" value="0" />
		<input type="checkbox" name="Tweetrix-filterURLs" value="1" <?php echo $options['filterURLs'] ? "checked='checked'" : ""; ?> />
	</p>
	<p>	Filter Numbers?
		<input type="hidden" name="Tweetrix-filterNumbers" value="0" />
		<input type="checkbox" name="Tweetrix-filterNumbers" value="1" <?php echo $options['filterNumbers'] ? "checked='checked'" : ""; ?> />
	</p>
	<p>	Title:
		<input	type="text" name="Tweetrix-title" value="<?php echo $options['title']; ?>"  />
	</p>
	<p>	Wrapper Div ID (use for styling):
		<input	type="text" name="Tweetrix-divid" value="<?php echo $options['divid']; ?>"  />
	</p>
	<input type="hidden" id="Tweetrix-submit" name="Tweetrix-submit" value="1" />
	<?php
}
/*-WIDGETIZE------------------------------------------------------------------*/
function widget_Tweetrix_init()
{
	if (!function_exists('register_sidebar_widget')) { return; }
	function widget_Tweetrix($args)
	{
		extract($args);
		$t = new Tweetrix();
		echo $before_widget.$before_title.$t->title.$after_title;
		$t->output();
		echo $after_widget;
	}
	register_sidebar_widget(Tweetrix::ID,'widget_Tweetrix');
	register_widget_control(Tweetrix::ID,'widget_Tweetrix_options');
}
add_action('plugins_loaded', 'widget_Tweetrix_init');
?>
