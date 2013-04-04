// JavaScript Document

var cfaq = [];
var showFaq = function (q, g) {
	
	if (cfaq[g] == undefined) cfaq[g] = 0;
	
	if ($('a_'+g+q).getStyle("display") != 'none') {
		$('q_'+g+cfaq[g]).removeClassName("on");
		new Effect.BlindUp('a_'+g+cfaq[g], { duration: 0.5});
		cfaq[g] = 0;
		return;
	}
	
	if (cfaq[g] > 0)
		$('q_'+g+cfaq[g]).removeClassName("on");
		
	$('q_'+g+q).addClassName("on");
	
	if (cfaq[g] > 0)
		new Effect.BlindUp('a_'+g+cfaq[g], { duration: 0.5});
	
	new Effect.BlindDown('a_'+g+q, { duration: 0.5});
	
	cfaq[g] = q;
	
}
