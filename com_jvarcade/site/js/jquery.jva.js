(function ($) {
	var jva = {

		loadModal: function(url, handler, width, height) {
			SqueezeBox.initialize();
			SqueezeBox.setOptions(SqueezeBox.presets, Object.merge(SqueezeBox.options || {}, {size: {x: width, y: height}}));
			SqueezeBox.assignOptions();
			SqueezeBox.setContent(handler, url);
		},

		rating: function(game_id, current_vote) {
			jQuery('#rate1').rating(JVA_AJAX_RATING_URL + game_id, {maxvalue:5,increment:.5,curvalue:current_vote});
		},

		mochiScore: function(gname, score, ajaxscore) {
			if (ajaxscore == 1) {
				$.post('/newscore.php', {
					"gname": gname,
					"score": score,
					"ajaxscore": ajaxscore
				}, function(data) {
					if (data) {
						jQuery.jva.loadModal(data, 'string', 300, 200);
					}
				});
			} else {
				document.getElementById('mochi_bridge_helper_form_score').value = score;
				document.getElementById('mochi_bridge_helper_form_gname').value = gname;
				document.getElementById('mochi_bridge_helper_form').submit();
			}
		},

		/*
		keepalive: function() {
			$.post(JVA_AJAX_URL, {
				"option": "com_jvarcade",
				"task": "keepalive",
				"tmpl": "component"
			}, function(data) {
				setTimeout(jQuery.jva.keepalive, JVA_KEEPALIVE_INTERVAL);
			});
		},
		*/
		
		/*roundCorners: function() {
				jQuery("div.pua_header_box").corner();
				jQuery("div.pua_folder").corner();
				jQuery("div.pua_folder_games").corner();
				jQuery("div.pu_ListContainer").corner("round tr tl");
				jQuery("div.pu_heading").corner("round tr tl");
				jQuery("div.pu_listbottom").corner("round br bl");
				jQuery("tr.pu_heading").corner("round tr tl");
				jQuery("#pufooter").corner("round br bl");
		},*/

		showTags: function(id, status, Itemid) {
			$.post(JVA_AJAX_URL, {
				"option": "com_jvarcade",
				"task": "gametags",
				"format": "raw",
				"tmpl": "component",
				"id": id,
				"status": status,
				"Itemid": Itemid
			}, function(data) {
				if (data) {
					jQuery('#tag').html(data);
				}
			});
		},
		
		saveTag: function(id, tag,Itemid) {
			$.post(JVA_AJAX_URL, {
				"option": "com_jvarcade",
				"task": "savetag",
				"format": "raw",
				"tmpl": "component",
				"id": id,
				"tag": tag
			}, function(data) {
				if (parseInt(data) == 1) {
					jQuery.jva.showTags(id, 1, Itemid);
				}
			});
		},
		
		savefave: function(id) {
			$.post(JVA_AJAX_URL, {
				"option": "com_jvarcade",
				"task": "savefave",
				"format": "raw",
				"tmpl": "component",
				"id": id
			}, function(data) {
				if (data) {
					jQuery('#fave').html(data);
				}
			});
		},
		
		delfave: function(id) {
			$.post(JVA_AJAX_URL, {
				"option": "com_jvarcade",
				"task": "delfave",
				"format": "raw",
				"tmpl": "component",
				"id": id
			}, function(data) {
				if (data) {
					jQuery('#fave').html(data);
				}
			});
		},
		
		reportGame: function(id) {
			$.post(JVA_AJAX_URL, {
				"option": "com_jvarcade",
				"task": "reportgame",
				"format": "raw",
				"tmpl": "component",
				"id": id
			}, function(data) {
				if (data) {
					alert(data);
				}
			});
		},

		
		downloadGame: function(id) {
			location.href = 'index.php?option=com_jvarcade&amp;task=downloadgame&amp;id=' + id;
		},
		
		showAddToContestPopup: function(game_id) {
			var url = '';
			if (typeof game_id != 'undefined') {
				game_id = 'cid[]=' + game_id;
				url = JVA_CONTESTLINK_ADDGAME_URL + game_id;
			} else {
				var games = jQuery("[name='cid[]']:checked");
				if (!games.length) {
					alert(COM_JVARCADE_CONTESTSLINK_GAME_EMPTY);
				} else {
					var game_ids = new Array();
					for (var i=0; i < games.length; i++) {
						game_ids.push('cid[]=' + games[i].value);
					}
					url = JVA_CONTESTLINK_ADDGAME_URL + game_ids.join('&');
				}
			}
			if(url) {
				jQuery.jva.loadModal(url, 'iframe', 500, 270);
			}
		},

		showAddGamesPopup: function(contest_id) {
			var url = '';
			if (typeof contest_id != 'undefined') {
				contest_id = 'cid[]=' + contest_id;
				url = JVA_CONTESTLINK_ADDCONTESTGAMES_URL + contest_id;
				jQuery.jva.loadModal(url, 'iframe', 500, 270);
			}
		},
		
		addGameToContest: function() {
			var contests = jQuery('#contestlist option:selected');
			var contest_ids = new Array();
			for (var i=0; i < contests.length; i++) {
				contest_ids.push(contests[i].value);
			}
			var game_ids = jQuery('#game_ids').val();
			$.post(JVA_AJAX_URL, {
				"option": "com_jvarcade",
				"task": "savegametocontest",
				"tmpl": "component",
				"game_ids": game_ids,
				"contest_ids": contest_ids.join(',')
			}, function(data) {
				if (window.parent.document.location.href.indexOf('editgame') != -1) {
					window.parent.jQuery.jva.showGameContests(game_ids);
					window.parent.SqueezeBox.close();
				} else if (data) {
					jQuery('body').html('<h1>'+data+'</h1>');
				}
			});
		},
		
		addContestGames: function() {
			var games = jQuery('#gameslist option:selected');
			var game_ids = new Array();
			for (var i=0; i < games.length; i++) {
				game_ids.push(games[i].value);
			}
			var contest_id = jQuery('#contest_id').val();
			$.post(JVA_AJAX_URL, {
				"option": "com_jvarcade",
				"task": "savegametocontest",
				"tmpl": "component",
				"game_ids": game_ids.join(','),
				"contest_ids": contest_id
			}, function(data) {
				if (window.parent.document.location.href.indexOf('editcontest') != -1) {
					window.parent.jQuery.jva.showContestGames(contest_id);
					window.parent.SqueezeBox.close();
				} else if (data) {
					jQuery('body').html('<h1>'+data+'</h1>');
				}
			});
		},
		
		showContestGames: function(contest_id) {
			$.post(JVA_AJAX_URL, {
				"option": "com_jvarcade",
				"task": "showcontestgames",
				"tmpl": "component",
				"format": "raw",
				"contest_id": contest_id
			}, function(data) {
				if (data) {
					jQuery('#contestgames').html(data);
				}
			});
		},
		
		showGameContests: function(game_id) {
			$.post(JVA_AJAX_URL, {
				"option": "com_jvarcade",
				"task": "showgamecontests",
				"tmpl": "component",
				"format": "raw",
				"game_id": game_id
			}, function(data) {
				if (data) {
					jQuery('#gamecontests').html(data);
				}
			});
		},
		
		deleteGameFromContest: function(contest_id, game_id, where) {
			if (confirm(COM_JVARCADE_CONTESTSLINK_DELETE_WARNING)) {
				$.post(JVA_AJAX_URL, {
					"option": "com_jvarcade",
					"task": "deletegamefromcontest",
					"tmpl": "component",
					"contest_id": contest_id,
					"game_id": game_id
				}, function(data) {
					if (parseInt(data) == 1) {
						if (where == 'game') {
							jQuery.jva.showGameContests(game_id);
						} else if (where == 'contest') {
							jQuery.jva.showContestGames(contest_id);
						}
					}
				});
			}
		},
		
		deleteGameFromContestMulti: function(id, where) {
			if (where == 'game') {
				var game_id = id;
				var contests = jQuery("[name='cid[]']:checked");
				var contest_id = new Array();
				for (var i=0; i < contests.length; i++) {
					contest_id.push(contests[i].value);
				}
				contest_id = contest_id.join(',');
			} else if (where == 'contest') {
				var contest_id = id;
				var games = jQuery("[name='cid[]']:checked");
				var game_id = new Array();
				for (var i=0; i < games.length; i++) {
					game_id.push(games[i].value);
				}
				game_id = game_id.join(',');
			}
			if (game_id == '' || contest_id == '') {
				alert(COM_JVARCADE_CONTESTSLINK_SAVE_EMPTY);
			} else {
				jQuery.jva.deleteGameFromContest(contest_id, game_id, where);
			}
		},
		
		validateContest: function() {
			if (jQuery('#name').val() == '' || jQuery('#startdatetime').val() == '' || jQuery('#startdatetime').val() == '0000-00-00 00:00:00' || (jQuery('#enddatetime').val() < jQuery('#startdatetime').val())) {
				var msg = new Array();
				msg.push(COM_JVARCADE_VALIDATION_ERROR);
				if (jQuery('#name').val() == '') {
				msg.push(COM_JVARCADE_CONTESTS_NAME_EMPTY);
				}
				if(jQuery('#startdatetime').val() == '' || jQuery('#startdatetime').val() == '0000-00-00 00:00:00') {
				msg.push(COM_JVARCADE_CONTESTS_START_EMPTY);
				}
				if (jQuery('#enddatetime').val() < jQuery('#startdatetime').val()) {
					msg.push(COM_JVARCADE_CONTESTS_END_LOWER_START);
				}
				alert (msg.join('\n'));
				return false;
			} else {
				return true;
			}
		},
		
		doMaintenance: function(service, context, id) {
			var gameid = 0;
			var contestid = 0;
			var langstr = '';
			id = (typeof id != 'undefined') ? parseInt(id) : 0;
			
			if (context == 'game') {
				gameid = id;
				langstr = (gameid ? 'GAME_' : '');
			} else if(context == 'contest') {
				contestid = id;
				langstr = (contestid ? 'CONTEST_' : '');
			}
			
			var confirm_msg = 'COM_JVARCADE_MAINTENANCE_' + langstr + 'DESC_' + service.toUpperCase();
			if (confirm(eval(confirm_msg))) {
				$.post(JVA_AJAX_URL, {
					"option": "com_jvarcade",
					"task": "domaintenance",
					"service": service,
					"context": context,
					"gameid": gameid,
					"contestid": contestid
				}, function(data) {
					if (data) {
						var JSON = jQuery.parseJSON(data);
						if (parseInt(JSON.status) != 0) {
							jQuery.jva.maintenanceMsg(JSON.msg);
						}
					}
				});
			}
		},
		
		clearMaintenance: function() {
			jQuery.jva.maintenanceMsg('');
		},
		
		doMigration: function(step) {
			if(step <= JVA_MAX_MIGRATION_STEPS) {
				if (step == 1) jQuery.jva.clearMaintenance();
				$.post(JVA_AJAX_URL, {
					"option": "com_jvarcade",
					"task": "domigration",
					"step": step
				}, function(data) {
					if (data) {
						var JSON = jQuery.parseJSON(data);
						if (typeof JSON == 'object') {
							jQuery.jva.appendMaintMsg(JSON.msg);
							if (parseInt(JSON.errnum) < 1) {
								jQuery.jva.doMigration(parseInt(step)+1);
							}
						} else {
							jQuery.jva.appendMaintMsg(COM_JVARCADE_MAINTENANCE_MIGRATION_FAILURE + " " + step);
						}
					} else {
						jQuery.jva.appendMaintMsg(COM_JVARCADE_MAINTENANCE_MIGRATION_FAILURE + " " + step);
					}
				});
			}
		},
	
		maintenanceMsg: function(msg) {
			jQuery('#maintenance-msg').html(msg);
		},

		appendMaintMsg: function(msg) {
			var old_msg = jQuery('#maintenance-msg').html();
			jQuery('#maintenance-msg').html(old_msg + msg);
		}
		
	};
	
	$.extend({"jva":jva});
	
})(jQuery);