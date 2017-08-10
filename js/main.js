	// Function for sending the file
	function processFileSend(){
		var recipient = document.getElementById('share_to_user_form').elements.item(0).value;
		var file_id = document.getElementById('share_to_user_form').elements.item(1).value;
		var msg = document.getElementById('share_to_user_form').elements.item(2).value;

		var xhr = new XMLHttpRequest();
 		xhr.open('GET', 'share_file.php?recipient='+recipient+'&file_id='+file_id+'&msg='+msg, true);
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xhr.send();

		xhr.onreadystatechange = function(){
			alert(xhr.responseText);
		}
	}

	// Function when a name is selected
	function nameSelected(user, file_id){
		var area = document.getElementById('share_to_user');
		/*var str_share = '<form id="share_to_user_form">\
							<input type="hidden" value="'+user+'">\
							<input type="hidden" value="'+file_id+'">\
							Enter message to the recipient:<br>\
							<input type="text" name="message" placeholder="Message to recepient...">\
							<input type="submit" value="Send" onclick="processFileSend()">\
						</form>'; */

		//area.innerHTML = str_share;
		document.getElementById('recipient').value = user;
		document.getElementById('share_search_result').innerHTML = "";
	}

	// Function to search users
	function searchUser(u, fid){
		//var file_id = document.getElementById('search_form').elements.item(0).value;
		var file_id = fid;

		var xhr = new XMLHttpRequest();
 		xhr.open('GET', 'search_user.php?u='+u+'&fid='+file_id, true);
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		//var data = 'upload_id=' + upload_id + '&comment_text=' + comment_text + '&comment_date=' + comment_date;
		xhr.send();

		xhr.onreadystatechange = function(){
			document.getElementById('share_search_result').innerHTML = xhr.responseText;
		}
	}

	// Function to show shareFileForm
	function showShareForm(){
		var file_id = document.getElementById('share_form').elements.item(0).value;
		var form = document.getElementById('share_file_form');

		var str_form = '<form id="search_form">\
							<input type="hidden" value="'+ file_id +'" >\
							<input type="text" name="share_to" placeholder="Share this file to..." onkeyup="searchUser(this.value)">\
						</form>';
		form.innerHTML = str_form;

	}

 	function fileSelect(evt) {
	    if (window.File && window.FileReader && window.FileList && window.Blob) {
	        var files = evt.target.files;
	        var result = '';
	        var file;
	    for (var i = 0; file = files[i]; i++) {
	        result += '<li>' + file.name + ' ' + file.size + ' bytes</li>';
	        }
	    document.getElementById('filesInfo').innerHTML = '<ul>' + result + '</ul>';
	    } else {
	    alert('The File APIs are not fully supported in this browser.');
	    }
	}
	document.getElementById('imgToUpload').addEventListener('change', fileSelect, false);


	if (window.File && window.FileReader && window.FileList && window.Blob) {
	    document.getElementById('imgToUpload').onchange = function(){
	        var files = document.getElementById('imgToUpload').files;
	        for(var i = 0; i < files.length; i++) {
	            resizeAndUpload(files[i]);
	        }
	    };
	} else {
	    alert('The File APIs are not fully supported in this browser.');
	}
	 
	function resizeAndUpload(file) {
	var reader = new FileReader();
	    reader.onloadend = function() {
	 
	    var tempImg = new Image();
	    tempImg.src = reader.result;
	    tempImg.onload = function() {
	 
	        var MAX_WIDTH = 1500;
	        var MAX_HEIGHT = 800;
	        var tempW = tempImg.width;
	        var tempH = tempImg.height;
	        if (tempW > tempH) {
	            if (tempW > MAX_WIDTH) {
	               tempH *= MAX_WIDTH / tempW;
	               tempW = MAX_WIDTH;
	            }
	        } else {
	            if (tempH > MAX_HEIGHT) {
	               tempW *= MAX_HEIGHT / tempH;
	               tempH = MAX_HEIGHT;
	            }
	        }
	 
	        var canvas = document.createElement('canvas');
	        canvas.width = tempW;
	        canvas.height = tempH;
	        var ctx = canvas.getContext("2d");
	        ctx.drawImage(this, 0, 0, tempW, tempH);
	        var dataURL = canvas.toDataURL("image/jpeg");
	 
	        var xhr = new XMLHttpRequest();
	        xhr.onreadystatechange = function(ev){
	            document.getElementById('filesInfo').innerHTML = 'Done!';
	        };
	 
	        xhr.open('POST', 'uploadResized.php', true);
	        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	        var data = 'image=' + dataURL;
	        xhr.send(data);
	      }
	 
	   }
	   reader.readAsDataURL(file);
	}