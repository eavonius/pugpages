<?php
namespace PugPages;

use Timber;

/**
 * Base class for pug page handling model.
 */
abstract class PageModel
{
    const PAGE_MODEL_CONTEXT_KEY = 'pugPageModel';
    const ERROR_MESSAGE_CONTEXT_KEY = self::PAGE_MODEL_CONTEXT_KEY . 'ErrorMessage';
    const SUCCESS_MESSAGE_CONTEXT_KEY = self::PAGE_MODEL_CONTEXT_KEY . 'SuccessMessage';
    const FIELD_ERROR_MESSAGES_CONTEXT_KEY = self::PAGE_MODEL_CONTEXT_KEY . 'FieldErrorMessages';

    private ?Array $context;

    /**
     * Creates an instance of the class.
     */
    public function __construct()
    {
        $this->context = Timber::get_context();

        $this->context[self::FIELD_ERROR_MESSAGES_CONTEXT_KEY] = [];
    }

    /**
     * Adds to the Timber context.
     *
     * @param string    $key    The key of the context item to add.
     * @param mixed     $value  The value of the context item to add.
     */
    public function setContext(string $key, $value)
    {
        $this->context[$key] = $value;
    }

    /**
     * Adds a message indicating an error related to a field of a form during submission.
     * 
     * @param string $fieldName The name attribute of the form field with an error.
     * @param string $message   The error message to display associated with the form field.
     */
    public function setFieldErrorMessage(string $fieldName, string $message)
    {
        $this->context[self::FIELD_ERROR_MESSAGES_CONTEXT_KEY][$fieldName] = $message;
    }

    /**
     * Sets a message indicating an error that occurred during a form submission.
     *
     * @param string $message The error message to display associated with the page.
     */
    public function setErrorMessage(string $message)
    {
        $this->context[self::ERROR_MESSAGE_CONTEXT_KEY] = $message;
    }

    /**
     * Sets a message indicating sucess after a form submission.
     *
     * @param string $message The success message to display associated with the page.
     */
    public function setSuccessMessage(string $message)
    {
        $this->context[self::SUCCESS_MESSAGE_CONTEXT_KEY] = $message;
    }

    /**
     * Returns whether a form submission has at least one error condition.
     *
     * @return bool
     */
    public function hasError() : bool
    {
        return (
            isset($this->context[self::ERROR_MESSAGE_CONTEXT_KEY]) || 
            count($this->context[self::FIELD_ERROR_MESSAGES_CONTEXT_KEY]) > 0
        );
    }

    /**
     * Shows the pug page matching the class filename.
     */
    protected function showPage()
    {
        $pagePath = get_called_class();
        $pagePath = substr(str_replace('\\', '/', $pagePath), 6);

        ViewRenderer::display($pagePath, $this->context);
    }

    /**
     * Called when the model should handle a request for the page.
     */
    public function handleRequest()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->onGet();
                break;
            case 'POST':
                $this->onPost();
                break;
        }
    }

    /**
     * Called when the page is retrieved.
     */
    public function onGet()
    {
        $this->showPage();
    }

    /**
     * Called when the page is posted to.
     */
    public function onPost()
    {
    }
}
