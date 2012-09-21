$(function () {
   $('.flip-fore a').bind('click', function() {
		var elem = $('.flip-fore');
        //alert('before');
        if (elem.data('flipped'))
        {
            //alert('flipped');
            elem.revertFlip();

            elem.data('flipped', false);
        }
        else
        {
            //alert('not flipped');
            elem.flip({
                direction: 'lr',
                speed: 350,
                color: '#ffffff',
                onBefore: function() {
                    elem.html(elem.siblings('.flip-back').html());
                }
            });
            elem.data('flipped', true);
        }
    });
});
