
$(document).ready(function(){

	// var API_KEY = "AIzaSyCaOAOglPoWOwYvYomcK-7clkRsNoaiwcQ"
	var API_KEY = "AIzaSyDK7jBMBDk3KDMmVYl--PE7uvRqBhpDI_8"
	var video =''

	// autosubmit form after 1 second
	$("#start").submit(function(event){
		setTimeout(function() {
			document.getElementById('youtubeform').submit();
			},1000);
		
	})
	

		$("#youtubeform").submit(function(event){
			event.preventDefault()
			
			var search = $("#searchCode").val()//searchbox
	
			videoSearch(API_KEY,search)
			
		})
	

	function videoSearch(key,search){

		$("#video").empty()//clear old data
		
		$.get("https://www.googleapis.com/youtube/v3/search?key="+key+"&type=video&part=snippet&maxResults=1&q="+search, 
		function(data){
			console.log(data)
			item = data.items;
			vidID = item[0].id.videoId;
			title = item[0].snippet.title;
			console.log(title);
			getVideoPlayer(vidID);

			
		})//endpoint
		}
		function getVideoPlayer(vidID){

				var player;

				function ready(){

					player = new YT.Player("videos",{
						videoId: vidID,
						playerVars:{
							'autoplay':1,
							'controls':0,
							'rel':0,
							'fs':0
						}
					
					});
				}
			

				var tag = document.createElement("script");
				tag.src = "//www.youtube.com/player_api";
				var firstScriptTag = document.getElementsByTagName("script")[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
				
				video = `<iframe width="953" height="580" src="https://www.youtube.com/embed/${vidID}?autoplay=1&controls=0" 
				allow="autoplay;" allowfullscreen></iframe>`;

				$("#videos").append(video)
				document.getElementById("videoID").value = vidID;
			getDuration(vidID,API_KEY);
    	}

			// get duration function
			async function getDuration(id,key){

			const url = `https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=${id}&key=${key}`;

			try {
				const response = await fetch(url);
				const data = await response.json();

				const videoDetails = data.items[0].contentDetails;
				const duration = videoDetails.duration;

				const parts = duration.match(/(\d+)/g);
				const minutes = parts[0];
				const seconds = parts[1] || '00';

				// return `${minutes}:${seconds}`;
				console.log(minutes,":", seconds);
				document.getElementById("min").value =minutes;
				document.getElementById("sec").value =seconds;
				var min = parseInt(minutes);
				var sec = parseInt(seconds);
				// call the timer function passing the minutes and seconds
				timer(min,sec);
				

			} catch (error) {
				console.error("Error fetching video duration:", error);
				return null;
			}
		}
	// function timer
		function timer(min,sec){
			var totalTime = min*60+sec;
			var timer;
			timer = setInterval(function(){
				totalTime--;

				if(totalTime < 0){
					clearInterval(timer);
					var score = Math.floor(Math.random() * (100 - 75 + 1)) + 75;
					alert("song finished score:"+ score);
					// sample delete call javascript to php
					deletesong();
					reloadPage();
				}else{
					//console.log(totalTime);
					document.getElementById('time').value = totalTime;
				}

			},1000);
		}
		function deletesong(){
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "delesong.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function () {
				if (xhr.readyState == 4 && xhr.status == 200) {
					// Response from the server (you can handle the response as needed)
					console.log(xhr.responseText);
				}
			};
			xhr.send("dummy_param=1");
		}
		function reloadPage(){
			setTimeout(function(){
				location.reload();
			},1000);

		}
		

}) //end of document ready
