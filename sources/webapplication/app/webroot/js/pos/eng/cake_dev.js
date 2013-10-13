var translations = (translations === null || translations === undefined)?{}:translation;
translations.eng = (translations.eng === null || translations.eng === undefined)?{}:translations.eng;
translations.eng.cake_dev = {"Debug setting does not allow access to this url.":"","Cache engines must use CacheEngine as a base class.":"","%s cache was unable to write '%s' to %s cache":"","Files cannot be atomically decremented.":"","Files cannot be atomically incremented.":"","Could not apply permission mask \\\"%s\\\" on cache file \\\"%s\\\"":"","%s is not writable":"","Method increment() not implemented for compressed cache in %s":"","Method decrement() not implemented for compressed cache in %s":"","Could not load configuration files: %s or %s":"","Cannot load configuration files with ..\/ in them.":"","No variable $config found in %s.php":"","Please install PHPUnit framework <info>(http:\/\/www.phpunit.de)<\/info>":"","Test case %s cannot be run via this shell":"","Test case %s not found":"","%s modified":"","Invalid object type.":"","Could not find %s.":"","AclComponent adapters must implement AclInterface":"","AclComponent::grant() is deprecated, use allow() instead":"","AclComponent::revoke() is deprecated, use deny() instead":"","Authorization adapter \\\"%s\\\" was not found.":"","Authorization objects must implement an authorize method.":"","Authentication adapter \\\"%s\\\" was not found.":"","Authentication objects must implement an authenticate method.":"","You must use cipher or rijndael for cookie encryption type":"","You must give a handler callback.":"","The request has been black-holed":"","\\\"roles\\\" section not found in configuration.":"","Neither \\\"allow\\\" nor \\\"deny\\\" rules were provided in configuration.":"","cycle detected when inheriting %s from %s. Path: %s":"","$controller needs to be an instance of Controller":"","$controller does not implement an isAuthorized() method.":"","CrudAuthorize::authorize() - Attempted access of un-mapped action \\\"%1$s\\\" in controller \\\"%2$s\\\"":"","Can't find application core file. Please create %score.php, and make sure it is readable by PHP.":"","Can't find application bootstrap file. Please create %sbootstrap.php, and make sure it is readable by PHP.":"","The eventKey variable is required":"","Missing plural form translation for \\\"%s\\\" in \\\"%s\\\" domain, \\\"%s\\\" locale.  Check your po file for correct plurals and valid Plural-Forms header.":"","Invalid key name":"","Missing logger classname":"","Stream %s not found":"","logger class %s does not implement a write method.":"","Could not load class %s":"","AclNode::node() - Couldn't find %s node identified by \\\"%s\\\"":"","BehaviorCollection::dispatchMethod() - Method %s not found in any attached behavior":"","Schema generation error: invalid column type %s for %s.%s does not exist in DBO":"","(Model::getColumnTypes) Unable to build model field data. If you are using a model without a database table, try implementing schema()":"","Invalid join model settings in %s":"","DbAcl::check() - Failed ARO\/ACO node lookup in permissions check.  Node references:\\nAro: ":"","DbAcl::check() - Failed ACO node lookup in permissions check.  Node references:\\nAro: ":"","ACO permissions key %s does not exist in DbAcl::check()":"","DbAcl::allow() - Invalid node":"","Callback parentNode() not defined in %s":"","AclBehavior is setup with more then one type, please specify type parameter for node()":"","Model \\\"%s\\\" is not associated with model \\\"%s\\\"":"","Datasource %s for TranslateBehavior of model %s is not connected":"","You cannot bind a translation named \\\"name\\\".":"","Association %s is already bound to model %s":"","%s doesn't exist":"","Unable to configure the session, setting %s failed.":"","Could not load %s to handle the session.":"","Chosen SessionHandler does not implement CakeSessionHandlerInterface it cannot be used with an engine key.":"","Error in Model %s":"","Invalid schema object":"","Column name or type not defined in schema":"","Column type %s does not exist":"","Could not describe table for %s":"","Could not find validation handler %s for %s":"","This field cannot be left blank":"","Method %s does not exist":"","Unknown status code":"","Connection timed out":"","From requires only 1 email address.":"","Sender requires only 1 email address.":"","Reply-To requires only 1 email address.":"","Disposition-Notification-To requires only 1 email address.":"","Return-Path requires only 1 email address.":"","Invalid email: \\\"%s\\\"":"","$headers should be an array.":"","Format not available.":"","Class \\\"%s\\\" not found.":"","The \\\"%s\\\" do not have send method.":"","Invalid format for Message-ID. The text should be something like \\\"<uuid@server.com>\\\"":"","File not specified.":"","File not found: \\\"%s\\\"":"","From is not specified.":"","You need to specify at least one destination for to, cc or bcc.":"","%s not found.":"","Unknown email configuration \\\"%s\\\".":"","Could not send email.":"","Unable to connect to SMTP server.":"","SMTP server did not accept the connection.":"","SMTP server did not accept the username.":"","SMTP server did not accept the password.":"","SMTP does not require authentication.":"","SMTP timeout.":"","SMTP Error: %s":"","Invalid response.":"","Invalid HTTP response.":"","HttpSocket::_decodeChunkedBody - Could not parse malformed chunk.":"","Invalid resource.":"","Class %s not found.":"","Unknown authentication method.":"","The %s do not support authentication.":"","Unknown authentication method for proxy.":"","The %s do not support proxy authentication.":"","HttpSocket::_buildRequestLine - Passed an invalid request line string. Activate quirks mode to do this.":"","HttpSocket::_buildRequestLine - The \\\"*\\\" asterisk character is only allowed for the following methods: %s. Activate quirks mode to work outside of HTTP\/1.1 specs.":"","Route classes must extend CakeRoute":"","Cannot create instance of %s, as it is abstract or is an interface":"","(ClassRegistry::init() could not create instance of %1$s class %2$s ":"","(ClassRegistry::init() Attempted to create instance of a class with a numeric name":"","Invalid Debugger output format.":"","Please change the value of 'Security.salt' in app\/Config\/core.php to a salt value specific to your application":"","Please change the value of 'Security.cipherSeed' in app\/Config\/core.php to a numeric (digits only) seed value specific to your application":"","%s changed to %s":"","%s NOT changed to %s":"","%s is a file":"","%s created":"","%s NOT created":"","%s removed":"","%s NOT removed":"","%s not found":"","%s not writable":"","%s copied to %s":"","%s NOT copied to %s":"","%s not created":"","Cannot use modParams with indexes that do not exist.":"","You cannot use an empty key for Security::cipher()":"","You cannot use an empty key for Security::rijndael()":"","You must specify the operation for Security::rijndael(), either encrypt or decrypt":"","You must use a key larger than 32 bytes for Security::rijndael()":"","You must define the $operator parameter for Validation::comparison()":"","You must define a regular expression for Validation::custom()":"","Could not find %s class, unable to complete validation.":"","Method %s does not exist on %s unable to complete validation.":"","Can not determine the mimetype.":"","Invalid input.":"","XML cannot be read.":"","The key of input must be alphanumeric":"","Invalid array":"","The input is not instance of SimpleXMLElement, DOMDocument or DOMNode.":"","Method %1$s::%2$s does not exist":"","Element Not Found: %s":"","You cannot extend an element which does not exist (%s).":"","You cannot have views extend themselves.":"","You cannot have views extend in a loop.":"","The \\\"%s\\\" block was left open. Blocks are not allowed to cross files.":"","$value must be a string.":"","Blocks can only contain strings.":"","Fatal Error":"","Error":"","File":"","Line":"","Notice":"","If you want to customize this error message, create %s":"","Missing Method in %s":"","The action %1$s is not defined in controller %2$s":"","Create %1$s%2$s in file: %3$s.":"","Missing Behavior":"","%s could not be found.":"","Create the class %s below in file: %s":"","Missing Component":"","Missing Database Connection":"","%s requires a database connection":"","%s driver is NOT enabled":"","If you want to customize this error message, create %s.":"","Missing Controller":"","Scaffold requires a database connection":"","Confirm you have created the file: %s":"","Missing Datasource":"","Datasource class %s could not be found.":"","Missing Datasource Configuration":"","The datasource configuration %1$s was not found in database.php.":"","Missing Helper":"","Missing Layout":"","The layout file %s can not be found or does not exist.":"","Missing Plugin":"","The application is trying to load a file from the %s plugin":"","Make sure your plugin %s is in the ":"","Loading all plugins":"","If you wish to load all plugins at once, use the following line in your ":"","Missing Database Table":"","Table %1$s for model %2$s was not found in datasource %3$s.":"","Missing View":"","The view for %1$s%2$s was not found.":"","Database Error":"","SQL Query":"","SQL Query Params":"","Private Method in %s":"","%s%s cannot be accessed directly.":"","Scaffold Error":"","Method _scaffoldError in was not found in the controller":"","Missing field name for FormHelper::%s":"","Cannot load the configuration file. Wrong \\\"configFile\\\" configuration.":"","Cannot load the configuration file. Unknown reader.":"","JsHelper:: Missing Method %s is undefined":"","MootoolsEngine::drop() requires a \\\"drag\\\" option to properly function":"","%s could not be found":"","%s does not implement a link() method, it is incompatible with PaginatorHelper":"","CakePHP: the rapid development php framework":"","Release Notes for CakePHP %s.":"","Read the changelog":"","URL rewriting is not properly configured on your server.":"","Your version of PHP is 5.2.8 or higher.":"","Your version of PHP is too low. You need PHP 5.2.8 or higher to use CakePHP.":"","Your tmp directory is writable.":"","Your tmp directory is NOT writable.":"","The %s is being used for caching. To change the config edit APP\/Config\/core.php ":"","Your cache is NOT working. Please check the settings in APP\/Config\/core.php":"","Your database configuration file is present.":"","Your database configuration file is NOT present.":"","Rename APP\/Config\/database.php.default to APP\/Config\/database.php":"","Cake is able to connect to the database.":"","Cake is NOT able to connect to the database.":"","PCRE has not been compiled with Unicode support.":"","Recompile PCRE with Unicode support by adding <code>--enable-unicode-properties<\/code> when configuring":"","Editing this Page":"","To change the content of this page, create: APP\/View\/Pages\/home.ctp.<br \/>\\nTo change its layout, create: APP\/View\/Layouts\/default.ctp.<br \/>\\nYou can also add some CSS styles for your pages at: APP\/webroot\/css.":"","Getting Started":"","New":"","CakePHP 2.0 Docs":"","The 15 min Blog Tutorial":"","More about Cake":"","CakePHP is a rapid development framework for PHP which uses commonly known design patterns like Active Record, Association Data Mapping, Front Controller and MVC.":"","Our primary goal is to provide a structured framework that enables PHP users at all levels to rapidly develop robust web applications, without any loss to flexibility.":"","Cake Software Foundation":"","Promoting development related to CakePHP":"","CakePHP":"","The Rapid Development Framework":"","CakePHP Documentation":"","Your Rapid Development Cookbook":"","CakePHP API":"","Quick Reference":"","The Bakery":"","Everything CakePHP":"","The Show":"","The Show is a live and archived internet radio broadcast CakePHP-related topics and answer questions live via IRC, Skype, and telephone.":"","CakePHP Google Group":"","Community mailing list":"","Live chat about CakePHP":"","CakePHP Code":"","For the Development of CakePHP Git repository, Downloads":"","CakePHP Lighthouse":"","CakePHP Tickets, Wiki pages, Roadmap":""};