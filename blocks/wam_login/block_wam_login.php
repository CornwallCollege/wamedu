<?php
class block_wam_login extends block_base {
	
	private $username;
	private $expiry;
	private $validity;
	private $key;
	private $wamRoot;
	private $subdomain;
	
	private function getToken() {
		$sExpiry = date("Y-m-d H:i:s", $this->expiry->getTimestamp());
		return hash('sha256', $this->username . $sExpiry . $this->key, false);
	}
	
	private function now_utc() {
		return new DateTime(null, "UTC");
	}
	
	public function has_config() {
        return true;
    }
	
	public function init() {
		$this->title = get_string('wam_login', 'block_wam_login');
	}
	
	public function specialization() {
		//called after the init method
		global $CFG;
		global $USER;
		
		require_once("$CFG->dirroot/config.php");
		
		if (isloggedin()) {
			
			$config = get_config('block_wam_login');
			$this->username = $USER->username;
			$this->wamRoot = $config->wamroot;
			$this->subdomain = $config->wamsubdomain;
			$this->stylesheeturl = $config->stylesheeturl;
			
			$portalConfig = get_config('local_wam_portal');
			$this->key = $portalConfig->secretkey;
			
			if (!empty($config->tokenvalidity)) {
				$this->validity = $config->tokenvalidity;
			} else {
				$this->validity = 120;
			}
			
			$oldTz = date_default_timezone_get();
			date_default_timezone_set("UTC");
			//$this->expiry = new DateTime(time() + (60 * $this->validity));
			$now = new DateTime(null, new DateTimeZone("UTC"));
			$minutesValid = $this->validity;
			
			$this->expiry = $now->add(new DateInterval("PT". $minutesValid . "M"));
			$this->expiry->setTimeZone(new DateTimeZone("UTC"));
			date_default_timezone_set($oldTz);
		}
	}
	
	public function get_content() {
		global $USER;
		global $CFG;
		
		require_once("$CFG->dirroot/config.php");
		$this->content         =  new stdClass;
		
		$oldTz = date_default_timezone_get();
		date_default_timezone_set("UTC");
			
		if (!isloggedin()) {
			$this->content->text = "";
		} else {
			$username = $this->username;
			$this->expiry->setTimeZone(new DateTimeZone("UTC"));
			$expiry = date("Y-m-d H:i:s", $this->expiry->getTimestamp());
			$token = $this->getToken();
			$wamRoot = $this->wamRoot;
			$stylesheetlink = "";
			$subdomain = $this->subdomain;
			if ($this->stylesheeturl != null && $this->stylesheeturl != "") {
				$stylesheeturl = $this->stylesheeturl;
				$stylesheetlink = "<link rel=\"stylesheet\" type=\"text/css\" href=\"$stylesheeturl\" />";
			}
			
			$this->content->text   = <<<EOT
			<div>
				$stylesheetlink
				<iframe id="wamFrame" style="max-width:95%;"></iframe>
			</div>
			<script type="text/javascript">
				var ryl;
				YUI().use('node', function(Y) {
					Y.on("domready", function() {
						var iFrame = Y.one('#wamFrame');
						iFrame.set('src', "$wamRoot/NotificationsExternal/Index?username=$username&expiry=$expiry&token=$token&subdomain=$subdomain");
					});
				});				
			</script>
EOT;
		}

		date_default_timezone_set($oldTz);
		return $this->content;
	}
}