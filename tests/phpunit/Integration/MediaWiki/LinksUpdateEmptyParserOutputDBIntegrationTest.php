<?php

namespace SMW\Tests\Integration\MediaWiki;

use LinksUpdate;
use ParserOutput;
use SMW\DIWikiPage;
use SMW\Tests\SMWIntegrationTestCase;
use SMW\Tests\Utils\PageCreator;
use Title;

/**
 *
 * @group SMW
 * @group SMWExtension
 * @group semantic-mediawiki-integration
 * @group mediawiki-databaseless
 * @group Database
 * @group medium
 *
 * @license GNU GPL v2+
 * @since   2.0
 *
 * @author mwjames
 */
class LinksUpdateEmptyParserOutputDBIntegrationTest extends SMWIntegrationTestCase {

	public function testDoUpdate() {
		$title   = Title::newFromText( __METHOD__ );
		$subject = DIWikiPage::newFromTitle( $title );

		$page = parent::getNonexistingTestPage( $title );
		parent::editPage( $page, '[[Has some property::LinksUpdateCompleteOnEmptyParserOutput]]' );

		$propertiesCountBeforeUpdate = count( $this->getStore()->getSemanticData( $subject )->getProperties() );

		$linksUpdate = new LinksUpdate( $title, new ParserOutput() );
		$linksUpdate->doUpdate();

		$this->assertCount(
			$propertiesCountBeforeUpdate,
			$this->getStore()->getSemanticData( $subject )->getProperties()
		);
	}

}
