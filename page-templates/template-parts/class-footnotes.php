<?php
/**
 * Footnotes Class File
 *
 * This file contains the definition of the Footnotes class, which provides functionality
 * for managing and displaying footnotes within a section of content.
 *
 * @package cb-arcus2025
 * @since 1.0.0
 */

/**
 * Footnotes class for managing and displaying footnotes.
 *
 * This class provides functionality to add, extract, and display footnotes
 * within a section of content.
 *
 * @package cb-arcus2025
 * @since 1.0.0
 */
class Footnotes {
    /**
     * Stores the footnotes for different sections.
     *
     * @var array
     */
    private $footnotes;

    /**
     * Counter to assign unique indices to footnotes.
     *
     * @var int
     */
    private $index;

    /**
     * Constructor for the Footnotes class.
     * Initializes the footnotes array and index counter.
     */
    public function __construct() {
        $this->footnotes = array();
        $this->index     = 1;
    }

    /**
     * Adds a footnote to a specific section.
     *
     * @param string $section The section to which the footnote belongs.
     * @param string $footnote The content of the footnote.
     * @return stdClass The footnote object that was added.
     */
    public function add_footnote( $section, $footnote ) {
        if ( ! isset( $this->footnotes[ $section ] ) ) {
            $this->footnotes[ $section ] = array();
        }

        $_footnote          = new stdClass();
        $_footnote->section = $section;
        $_footnote->index   = $this->index++;
        $_footnote->content = $footnote;

        array_push( $this->footnotes[ $section ], $_footnote );

        return $_footnote;
    }

    /**
     * Extracts footnotes from a string and replaces them with links.
     *
     * @param string $section The section to which the footnotes belong.
     * @param string $input_string The content string containing footnotes.
     * @return array An array containing the modified content and extracted footnotes.
     */
    public function extract_footnote( $section, $input_string ) {
        $pattern           = '/\[Footnote\](.*?)\[\/Footnote\]/i';
        $current_footnotes = array();
        $modified_string   = preg_replace_callback(
            $pattern,
            function ( $matches ) use ( $section, $current_footnotes ) {
                $footnote  = $matches[1];
                $_footnote = $this->add_footnote( $section, $footnote );
                array_push( $current_footnotes, $_footnote );
                return $this->link_to_footnote( $_footnote );
            },
            $input_string,
            -1,
            $count
        );

        return array(
            'content'   => $modified_string,
            'footnotes' => $current_footnotes,
        );
    }

    /**
     * Generates an HTML link to a specific footnote.
     *
     * @param stdClass $footnote The footnote object containing section and index information.
     * @return string The HTML link to the footnote.
     */
    public function link_to_footnote( $footnote ) {
        return "<a href=\"#{$footnote->section}-{$footnote->index}\" class=\"footnote-link\"><sup>{$footnote->index}</sup></a>";
    }

    /**
     * Displays the footnotes for a specific section.
     *
     * @param string $section The section whose footnotes are to be displayed.
     */
    public function display_footnotes( $section ) {
        if ( ! empty( $this->footnotes[ $section ] ) ) {
            ?>
            <ol class="footnotes-section">
                <?php
                foreach ( $this->footnotes[ $section ] as $footnote ) {
                    ?>
                    <li value="<?= esc_attr( $footnote->index ); ?>" id="<?= esc_attr( "{$section}-{$footnote->index}" ); ?>"><?= wp_kses_post( $footnote->content ); ?></li>
                    <?php
                }
                ?>
            </ol>
            <?php
        }
    }

    /**
     * Checks if there are any footnotes for a given section.
     *
     * @param string $section The section to check for footnotes.
     * @return bool True if footnotes exist, false otherwise.
     */
    public function has_footnotes( $section ) {
        return ! empty( $this->footnotes[ $section ] );
    }
    
}

$footnotes = new Footnotes();