<script src="https://apis.google.com/js/api:client.js"></script>
<script type="text/javascript">
	var googleUser = {};
	
	function startApp(){
		gapi.load('auth2', function(){
			auth2 = gapi.auth2.init({
				client_id: '967226832404-84ueserqebh6qn317n0n1h6asot6305q.apps.googleusercontent.com',
				cookiepolicy: 'single_host_origin',
			});
			
			attachSignin(document.getElementById('google'));
		});
	};

	function attachSignin(element) {
		auth2.attachClickHandler(element, {},
			function(googleUser) {
				var profile = googleUser.getBasicProfile();
				var fields = new Object();
					fields._request = 'users';
					fields._action = 'loginThirdParty';
					fields.name = profile.getName();
					fields.email = profile.getEmail();
					fields.login = {name:'google', id:profile.getId(), img:profile.getImageUrl()};
				
				checkUsers(fields);
			}, function(error) {
				alert(JSON.stringify(error, undefined, 2));
			}
		);
	}
</script>


<div id="google" class="box2" onClick="startApp();"><span class="icon google">G</span>Login google</div>



<!--<div id="gSignInWrapper">
<span class="label">Sign in with:</span>
<div id="customBtn" class="customGPlusSignIn">
<span class="icon"></span>
<span class="buttonText" onclick="startApp();">Google</span>
</div>
</div>
<div id="name"></div>-->

