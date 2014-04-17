CREATE TABLE IF NOT EXISTS User(
	U_id INT NOT NULL AUTO_INCREMENT,
	U_email CHAR(255) NOT NULL,
	U_first CHAR(255),
	U_last CHAR(255),
	U_pwd CHAR(255) NOT NULL,
	U_reg_user BOOLEAN DEFAULT false,
	U_confirmed BOOLEAN DEFAULT false,
	U_reg_date CHAR(255) NOT NULL, 
	U_affiliation CHAR(255) DEFAULT 'N/A',
	PRIMARY KEY(U_id, U_email)
);

CREATE TABLE `Query` (
  `id` int(11) NOT NULL auto_increment,
  `U_id` int(11) NOT NULL,
  `vsql` text default NULL,
  `targetFormatURI` varchar(1024) default NULL,
  `targetTypeURI` varchar(1024) default NULL,
  `viewURI` varchar(1024) default NULL,
  `viewerSetURI` varchar(1024) default NULL,
  `artifactURL` varchar(1024) default NULL,
  `dateSubmitted` datetime NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `Pipeline` (
  `id` int(11) NOT NULL auto_increment,
  `queryID` int(11) NOT NULL,
  `viewURI` varchar(1024) default NULL,
  `viewerURI` varchar(1024) default NULL,
  `toolkit` varchar(1024) default NULL,
  `outputFormat` varchar(1024) default NULL,
  `requiresInputURL` bool,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `Services` (
  `id` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `URI` varchar(1024) default NULL,
  `dateAdded` datetime NOT NULL,
  `status` bool NOT NULL,
  `lastStatusCheck` datetime NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `PipelinexService` (
  `pipelineID` int(11) NOT NULL,
  `serviceID` int(11) NOT NULL,
  `position` int(11) default NULL
);

CREATE TABLE `PipelinexViewerSet` (
  `pipelineID` int(11) NOT NULL,
  `viewerSetID` int(11) NOT NULL
);

CREATE TABLE `ViewerSets` (
  `id` int(11) NOT NULL auto_increment,
  `URI` varchar(1024) NOT NULL,
   PRIMARY KEY  (`id`)
);

CREATE TABLE `QueryParameters` (
 `id` int(11) NOT NULL auto_increment,
 `queryID` int(11) NOT NULL,
 `URI` varchar(1024) NOT NULL,
 `value` varchar(1024) NOT NULL,
 PRIMARY KEY (`id`),
 FOREIGN KEY(`queryID`) REFERENCES Query(id)
);

CREATE TABLE `PipelineExecution` (
  `id` int(11) NOT NULL auto_increment,
  `dateExecuted` datetime NOT NULL,
  `pipelineID` int(11) NOT NULL,
  `resultURL` varchar(1024) default NULL,
  `serviceIndex` INT(11) default NULL,
  `completedNormally` bool,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (pipelineID) REFERENCES Pipeline(id)
);


