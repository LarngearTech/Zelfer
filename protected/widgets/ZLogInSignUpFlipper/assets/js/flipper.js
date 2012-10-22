$(function () {
	$(document).on('click', '.flip-fore a', function() {
		var elem = $('.flip-fore');
        if (elem.data('flipped'))
        {
            elem.revertFlip();

            elem.data('flipped', false);
        }
        else
        {
            elem.flip({
                direction: 'lr',
                speed: 250,
                color: '#ffffff',
                onBefore: function() {
                    elem.html(elem.siblings('.flip-back').html());
                }
            });
            elem.data('flipped', true);
        }
    });
});
