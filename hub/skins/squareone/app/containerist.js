var containerist = (function() {	
	$.support.cors = true; // Set cors flag to true, so jQuery allows cross-domain requests in browsers that don't support it
	var self = this;
	self.elements = null;
	self.DEBUG = false;


	self.init = function( options ) {

		self.onFinish = options ? options.onFinish : function(){};

		self.elements = ($('[show=embed]'));
		self.elements.each(function( index ) {
			/* einfaches load würde viel weniger workload bedeuten und zuverlässiger arbeiten */
			var ctn = $(this),
					ctnContent = ctn.find('.contents');
					r = DEBUG ? Math.floor(Math.random()*10*1000/2) : 0; // turn debug on to simulate latency
			
			//console.log("loading", ctn.attr('data-source'), r);

			$.ajax({
				url:			ctn.attr('data-source'),
				content:		ctnContent,
				crossDomain:	true,
				dataType:		'html',
				success:		function(data, textStatus, jqXHR) {
					setTimeout(function() {
						//console.log("entered", ctn.attr('data-source'), data, textStatus, jqXHR);
						ctnContent.html(data);

						var css = ctnContent.find('link'),
								l = css.length,
								i = 0;

						if(l == 0) {
							show(ctn, ctnContent);
						} else {
							css.load(function() {
								i++;
								if(i == l) show(ctn, ctnContent);
							});
						}
					}, r);

					if ( index === self.elements.length-1 ){
						return self.onFinish();
					}
				},

				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				},
			});

		});
	}

	self.onLoadingComplete = function( container ){};

	self.show = function(ctn, ctnContent) {
		ctn.animate(
			{ height: ctnContent.outerHeight() },
			200, function() {
				$(this).css('height', ''); // reset height
			}
		);

		ctnContent.animate(
			{ opacity: 1 },
			200,
			function() {
				ctn.removeClass('ctn--loading');
			}
		);
	}

	return self;
})();

