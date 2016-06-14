<?php
namespace JaccoVanDerPost\Jpfaq\Controller;

/***************************************************************
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
 ***************************************************************/

/**
 * Controller for the Question object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class QuestionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {


    /**
     * questionRepository
     *
     * @var \JaccoVanDerPost\Jpfaq\Domain\Repository\QuestionRepository
     * @inject
     */
    protected $questionRepository = NULL;


    /**
     * categoryRepository
     *
     * @var \JaccoVanDerPost\Jpfaq\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = NULL;

    /**
     * Initializes the current action
     *
     * @return void
     */
    protected function initializeAction()
    {


        // stylesheets includes in header
        $includes = '';
        foreach ($this->settings["includeCss"] as $cssFile) {
            $path = "";
            $mediatype = "all";
            if (isset($cssFile["path"])) {
                $path .= str_replace("EXT:", \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()), $cssFile["path"]);
                if (isset($cssFile["mediatype"])) {
                    $mediatype = $cssFile["mediatype"];
                }
                $includes .= chr(13) . '<link rel="stylesheet" type="text/css" href="' . $path . '" media="' . $mediatype . '" />';
            }
        }
        $GLOBALS["TSFE"]->additionalHeaderData['jpFaq'] = $includes;
            $includeJquery = $this->settings["includeJquery"];
            $pathIncludeJquery = "";
            if (isset($includeJquery["path"])) {
                $pathIncludeJquery .= str_replace("EXT:", \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()), $includeJquery["path"]);
            }
            else  {
                $pathIncludeJquery = NULL;
            }


        // load quicksearch js
        $includeQuicksearch = $this->settings["includeQuicksearch"];
        $pathIncludeQuicksearch = "";
        if (isset($includeQuicksearch["path"])) {
            $pathIncludeQuicksearch .= str_replace("EXT:", \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()), $includeQuicksearch["path"]);
        }


        // put js in footer
        if (isset($pathIncludeJquery)) {
            $GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($GLOBALS['TSFE']->tmpl->getFileName($pathIncludeJquery), $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '');
        }
        if (isset($pathIncludeQuicksearch)) {
            if ($this->settings['flexform']['showSearch'] == 1) {
                $GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($GLOBALS['TSFE']->tmpl->getFileName($pathIncludeQuicksearch), $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '');
            }
        }
    }


    /**
     * Displays all Questions
     *
     * @return string The rendered list view
     */
    public function listAction()
    {
        $numberOfQuestions = $this->questionRepository->countAll();

        // get selected category from Flexform
        $selectedCategory = intval($this->settings['flexform']['selectCategory']);
        // get all questions belonging to this category
        $flexformPid = intval($this->settings['flexform']['selectPid']);
        $questions = $this->questionRepository->getAllQuestionsForCategory($selectedCategory, $flexformPid);
        $this->view->assign('showSearchForm', $this->settings['flexform']['showSearch']);
        $this->view->assign('questions', $questions);
        $this->view->assign('category', $this->categoryRepository->getCategoryNameForCategoryUid($selectedCategory));
        $this->view->assign('categoryUid', $selectedCategory);

        //set fold / unfold js
        $js = <<<HEREDOC
        $(document).ready(function(){
            jQuery('.jpfaqHide$selectedCategory').hide();
            jQuery('ul.listCategory$selectedCategory .toggleTrigger').next().hide();
            jQuery('ul.listCategory$selectedCategory .toggleTrigger').click(function(){
                jQuery(this).next().toggleClass("active").slideToggle('fast');
                jQuery(this).toggleClass("questionUnfolded");
                if (jQuery(".tx-jpfaq-pi1 ul.listCategory$selectedCategory li").children(':first-child').length == jQuery(".tx-jpfaq-pi1 ul.listCategory$selectedCategory li").children(':first-child.questionUnfolded').length) {
                    jQuery('.jpfaqShow$selectedCategory').hide();
                    jQuery('.jpfaqHide$selectedCategory').show();
                } else {
                    jQuery('.jpfaqHide$selectedCategory').hide();
                    jQuery('.jpfaqShow$selectedCategory').show();
                }
            });
            jQuery('.jpfaqShow$selectedCategory').click(function(){
                jQuery('.toggleTriggerContainer$selectedCategory').removeClass("active");
                jQuery('.toggleTriggerContainer$selectedCategory').addClass("active").slideDown('fast');
                jQuery('ul.listCategory$selectedCategory .toggleTrigger').removeClass("questionUnfolded");
                jQuery('ul.listCategory$selectedCategory .toggleTrigger').addClass("questionUnfolded");
                jQuery('.jpfaqShow$selectedCategory').hide();
                jQuery('.jpfaqHide$selectedCategory').show();
            });
            jQuery('.jpfaqHide$selectedCategory').click(function(){
                jQuery('.toggleTriggerContainer$selectedCategory').removeClass("active").slideUp('fast');
                jQuery('ul.listCategory$selectedCategory .toggleTrigger').removeClass("questionUnfolded");
                jQuery('.jpfaqHide$selectedCategory').hide();
                jQuery('.jpfaqShow$selectedCategory').show();
            });
        });
HEREDOC;

        //load dynamic js in footer
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('jpfaq ' . $this->categoryRepository->getCategoryNameForCategoryUid($selectedCategory), $js, $compress = TRUE, $forceOnTop = FALSE);
    }


    /**
     * Displays a single Question
     *
     * @param \JaccoVanDerPost\Jpfaq\Domain\Model\Question $question the Question to display
     * @return string The rendered view
     */
    public function showAction(\JaccoVanDerPost\Jpfaq\Domain\Model\Question $question)
    {
        $this->view->assign('question', $question);
    }


    /**
     * Creates a new Question and forwards to the list action.
     *
     * @param \JaccoVanDerPost\Jpfaq\Domain\Model\Question $newQuestion a fresh Question object which has not yet been added to the repository
     * @return string An HTML form for creating a new Question
     * @dontvalidate $newQuestion
     */
    public function newAction(\JaccoVanDerPost\Jpfaq\Domain\Model\Question $newQuestion = NULL)
    {
        $this->view->assign('newQuestion', $newQuestion);
    }


    /**
     * Creates a new Question and forwards to the list action.
     *
     * @param \JaccoVanDerPost\Jpfaq\Domain\Model\Question $newQuestion a fresh Question object which has not yet been added to the repository
     * @return void
     */
    public function createAction(\JaccoVanDerPost\Jpfaq\Domain\Model\Question $newQuestion)
    {
        $this->questionRepository->add($newQuestion);
        $this->addFlashMessage('Your new Question was created.');
        $this->redirect('list');
    }


    /**
     * Updates an existing Question and forwards to the index action afterwards.
     *
     * @param \JaccoVanDerPost\Jpfaq\Domain\Model\Question $question the Question to display
     * @return string A form to edit a Question
     */
    public function editAction(\JaccoVanDerPost\Jpfaq\Domain\Model\Question $question)
    {
        $this->view->assign('question', $question);
    }


    /**
     * Updates an existing Question and forwards to the list action afterwards.
     *
     * @param \JaccoVanDerPost\Jpfaq\Domain\Model\Question $question the Question to display
     */
    public function updateAction(\JaccoVanDerPost\Jpfaq\Domain\Model\Question $question)
    {
        $this->questionRepository->update($question);
        $this->addFlashMessage('Your Question was updated.');
        $this->redirect('list');
    }


    /**
     * Deletes an existing Question
     *
     * @param \JaccoVanDerPost\Jpfaq\Domain\Model\Question $question the Question to be deleted
     * @return void
     */
    public function deleteAction(\JaccoVanDerPost\Jpfaq\Domain\Model\Question $question)
    {
        $this->questionRepository->remove($question);
        $this->addFlashMessage('Your Question was removed.');
        $this->redirect('list');
    }
}
