if ( imgs.length > 0 )
{
	var imgpreload = new Array();
	for ( i=0; i<=imgs.length-1;i++)
	{
		imgpreload[i] = new Image();
		imgpreload[i].src = imgs[i];
	}

	var changetime = 2500;
	var curimg = -1;
	var playing = 0;
	sliding = 1;
}

function imgchange(imgsrc)
{
	eval('parent.slideimg.filters.blendTrans.stop();');
	eval('parent.slideimg.style.filter="blendTrans(duration=1.5)"');
	eval('parent.slideimg.filters.blendTrans.Apply();');
	eval('parent.slideimg.src='+imgsrc+'.src;');
	eval('parent.slideimg.filters.blendTrans.Play();');
}

function imgmsg(i)
{
	if ( i == "" ) return;
	eval('parent.slideimg.filters.blendTrans.stop();');
	eval('parent.slideimg.style.filter="blendTrans(duration=1.5)"');
	eval('parent.slideimg.filters.blendTrans.Apply();');
	parent.slideimg.src=i;
	eval('parent.slideimg.filters.blendTrans.Play();');
	slidepause();
}



function slideshowstart()
{
	if ( playing == 1 )
	{
		if ( curimg == imgs.length -1 ) curimg = 0;
		else curimg++;
		imgchange('imgpreload[curimg]');
		setTimeout("slideshowstart()",2500);
	}
}

function slideplay()
{
	if ( sliding != 1 ) return;
	if ( playing == 1 ) return;
	playing = 1;
	//setTimeout("slideshowstart()",0);
	slideshowstart();
}

function slidepause(n)
{
	if ( n )
	{
		curimg = n - 1;
		imgchange('imgpreload[curimg]');
	}
	if ( sliding != 1 ) return;
	playing = 0;
}

function slidenext()
{
	if ( curimg == imgs.length -1 ) curimg = -1;
	curimg = curimg + 2;
	slidepause(curimg);
}

function slideprev()
{
	if ( curimg == 0 ) curimg = imgs.length;
	slidepause(curimg);
}