KindEditor.plugin('shipin', function(K) {
	var self = this, name = 'shipin';
	self.clickToolbar(name, function() {
		var lang = self.lang(name + '.'),
			html = [
			    '<div style="padding:20px;">',
				//url
				'<div class="ke-dialog-row">',
				'<label for="keUrl" style="width:40px;">URL</label>',
				'<input class="ke-input-text" type="text"  name="url" value="http://" style="width:320px;" /> &nbsp;',
				'<label for="keUrl" style="width:250px;text-align:center">仅支持腾讯和优酷视频链接</label>',
				'</div>',
				'</div>'
				].join(''),
			dialog = self.createDialog({
				name : name,
				width : 450,
				title : self.lang(name),
				body : html,
				yesBtn : {
					name : self.lang('yes'),
					click : function(e) {
							url = K.trim(input.val());
							if (url === '') {
								alert(lang.pleaseInput);
								input[0].focus();
								return;
							}
							
							if (url == 'http://' || K.invalidUrl(url)) {
								alert(self.lang('invalidUrl'));
								input[0].focus();
								return;
						    }
							var Expression=/http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
							var objExp=new RegExp(Expression);
							if(objExp.test(url)==true){
							}else{
                                alert(self.lang('invalidUrl'));
								input[0].focus();
								return;
							}
							var domain = url.match(/http[s]?:\/\/(.*?)([:\/]|$)/);
							var domain2 = domain[1].toLowerCase();
	
							if(domain2.indexOf('qq.com')>0 || domain2.indexOf('youku.com')>0){
							}else{
                                alert('仅支持腾讯和优酷视频链接');
								input[0].focus();
								return;
							}

							html = '<p><iframe frameborder="0" width="384" height="298" src="' + url + '"  allowfullscreen  ></iframe></p> ';
						    self.insertHtml(html).hideDialog().focus();
					}
				}
			}),
			input = K('input', dialog.div);
		input[0].focus();
	});
});
