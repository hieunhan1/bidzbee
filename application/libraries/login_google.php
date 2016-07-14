<meta name="google-signin-client_id" content="967226832404-84ueserqebh6qn317n0n1h6asot6305q.apps.googleusercontent.com">
<!--<div id="signinGoogle" class="box"></div>-->
<div class="google g-signin2" data-onsuccess="onSignIn"></div>
<style type="text/css">
.abcRioButtonContentWrapper{
	border: solid 1px #EEE;
}
</style>
<script type="text/javascript">
	function onSignIn(googleUser) {
		var profile = googleUser.getBasicProfile();
		var fields = new Object();
			fields._request = 'checkUser';
			fields.name = profile.getName();
			fields.email = profile.getEmail();
			fields.login = {name:'google', id:profile.getId(), img:profile.getImageUrl()};

		checkUsers(fields);
	}
	function signOutGoogle() {
		var auth2 = gapi.auth2.getAuthInstance();
		auth2.signOut().then(function () {
			console.log('User signed out.');
		});
	}
	function onSuccessGoogle(googleUser) {
		var profile = googleUser.getBasicProfile();
		var fields = new Object();
			fields._request = 'checkUser';
			fields.name = profile.getName();
			fields.email = profile.getEmail();
			fields.login = {name:'google', id:profile.getId(), img:profile.getImageUrl()};

		checkUsers(fields);
	}
	function onFailureGoogle(error) {
		alert('Login failure.');
		console.log(error);
	}
	function renderButtonGoogle() {
		gapi.signin2.render('signinGoogle', {
			'scope': 'profile email',
			'width': 240,
			'height': 50,
			'background-color': '#cf4332',
			'longtitle': true,
			'theme': 'dark',
			'onsuccess': onSuccessGoogle,
			'onfailure': onFailureGoogle,
		});
	}
</script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<!--<script src="https://apis.google.com/js/platform.js?onload=renderButtonGoogle" async defer></script>-->