
-- Hopefully this will be the future refactored version of User table
-- or at least hacked to share ids
CREATE TABLE IF NOT EXISTS `Users`(
	id int(11) NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
);

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

CREATE TABLE IF NOT EXISTS `Queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `vsql` text default NULL,
  `formatURI` varchar(1024) default NULL,
  `typeURI` varchar(1024) default NULL,
  `targetFormatURI` varchar(1024) default NULL,
  `targetTypeURI` varchar(1024) default NULL,
  `viewURI` varchar(1024) default NULL,
  `viewerSetURI` varchar(1024) default NULL,
  `artifactURL` varchar(1024) default NULL,
  `dateSubmitted` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`userID`) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Pipelines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `queryID` int(11) NOT NULL,
  `viewURI` varchar(1024) default NULL,
  `viewerURI` varchar(1024) default NULL,
  `toolkit` varchar(1024) default NULL,
  `outputFormat` varchar(1024) default NULL,
  `requiresInputURL` bool,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`queryID`) REFERENCES Queries(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `URI` varchar(1024) default NULL,
  `dateAdded` datetime NOT NULL,
  `status` bool NOT NULL,
  `lastStatusCheck` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`userID`) REFERENCES Users(id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS `ViewerSets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `URI` varchar(1024) NOT NULL,
   PRIMARY KEY  (`id`)
);


CREATE TABLE IF NOT EXISTS `PipelineServices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pipelineID` int(11) NOT NULL,
  `serviceID` int(11) NOT NULL,
  `position` int(11) default NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pipelineID`) REFERENCES Pipelines(id) ON DELETE CASCADE,
  FOREIGN KEY (`serviceID`) REFERENCES Services(id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS `PipelineViewerSets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pipelineID` int(11) NOT NULL,
  `viewerSetID` int(11) NOT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`pipelineID`) REFERENCES Pipelines(id)  ON DELETE CASCADE,
   FOREIGN KEY (`viewerSetID`) REFERENCES ViewerSets(id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS `QueryParameters` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `queryID` int(11) NOT NULL,
 `URI` varchar(1024) NOT NULL,
 `value` varchar(1024) NOT NULL,
 PRIMARY KEY (`id`),
 FOREIGN KEY(`queryID`) REFERENCES Queries(id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS `PipelineStatuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateExecuted` datetime NOT NULL,
  `pipelineID` int(11) NOT NULL,
  `resultURL` varchar(1024) default NULL,
  `serviceIndex` INT(11) default NULL,
  `completedNormally` bool,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`pipelineID`) REFERENCES Pipelines(id) ON DELETE CASCADE

);

-- Error tables form a hierarchy
CREATE TABLE IF NOT EXISTS `Errors` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`timeOccurred` datetime NOT NULL,
	`userID` int(11) NOT NULL,
	`message` varchar(1024) default NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY (`userID`) REFERENCES Users(id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS `PipelineErrors` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`parentID` int(11) NOT NULL,
	`pipelineID` int(11) NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY (`parentID`) REFERENCES Errors(id) ON DELETE CASCADE,
	FOREIGN KEY (`pipelineID`) REFERENCES Pipelines(id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS ServiceErrors (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`parentID` int(11) NOT NULL,
	`pipelineServiceID` int(11) NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY (`parentID`) REFERENCES PipelineErrors(id) ON DELETE CASCADE,
	FOREIGN KEY (`pipelineServiceID`) REFERENCES PipelineServices(id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS ServiceTimeoutErrors(
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`parentID` int(11) NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`parentID`) REFERENCES ServiceErrors(id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS ServiceExecutionErrors(
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`parentID` int(11) NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`parentID`) REFERENCES ServiceErrors(id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS InputDataURLErrors(
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`parentID` int(11) NOT NULL,
	`datasetURL` varchar (1024) NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`parentID`) REFERENCES PipelineErrors(id) ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS `QueryErrors` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`parentID` int(11) NOT NULL,
	`queryID` int(11) NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY (`parentID`) REFERENCES Errors(id) ON DELETE CASCADE,
	FOREIGN KEY (`queryID`) REFERENCES Queries(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `SyntaxErrors`(
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`parentID` int(11) NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`parentID`) REFERENCES QueryErrors(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `NoPipelineResultsErrors`(
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`parentID` int(11) NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`parentID`) REFERENCES QueryErrors(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS `MalformedURIErrors` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`parentID` int(11) NOT NULL,
	`uri` varchar(1024),
	PRIMARY KEY(`id`),
	FOREIGN KEY (`parentID`) REFERENCES QueryErrors(id) ON DELETE CASCADE
);






