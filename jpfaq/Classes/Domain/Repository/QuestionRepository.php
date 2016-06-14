<?php
namespace JaccoVanDerPost\Jpfaq\Domain\Repository;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Jacco van der Post <jacco@typo3-webdesign.nl>, iD Webdesign
 *  	
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Repository for JaccoVanDerPost\Jpfaq\Domain\Model\Question
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class QuestionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    /**
     *  Get all questions for a categoryUID
     * 
     * @param integer $categoryUID
     * @param integer $flexformPid
     * @return object
     */
    public function getAllQuestionsForCategory($categoryUID, $flexformPid) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        if ($categoryUID) {
            $query->matching($query->logicalAnd($query->contains('category', $categoryUID),$query->equals('pid',$flexformPid)));
        } else  {
            $query->matching($query->equals('pid',$flexformPid));
        }
        return $query->execute();
    }

}

