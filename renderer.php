<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Renderer for outputting parts of a question belonging to the legacy
 * adaptive (no penalties) behaviour.
 *
 * @package    qbehaviour
 * @subpackage adaptivenopenalty
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../adaptive/renderer.php');


/**
 * Renderer for outputting parts of a question belonging to the legacy
 * adaptive (no penalties) behaviour.
 *
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qbehaviour_savenongraded_renderer extends qbehaviour_adaptive_renderer 
{
    protected function penalty_info($qa, $mark) 
    {
        return '';
    }


    /**
     * Several behaviours need a submit button, so put the common code here.
     * The button is disabled if the question is displayed read-only.
     * @param question_display_options $options controls what should and should not be displayed.
     * @return string HTML fragment.
     */
    protected function submit_button(question_attempt $qa, question_display_options $options) 
    {
        $attributes = 
            array
            (
                'type' => 'submit',
                'id' => $qa->get_behaviour_field_name('submit'),
                'name' => $qa->get_behaviour_field_name('submit'),
                'value' => get_string('save', 'qbehaviour_savenongraded'),
                'alt' => get_string('save', 'qbehaviour_savenongraded'),
                'class' => 'submit btn savenow'
            );

        //if the question is read-only, prevent the button from being clicked
        if ($options->readonly)
            $attributes['disabled'] = 'disabled';

        //generate a new submit button 
        $output = html_writer::empty_tag('input', $attributes);

        //if this question isn't read-only, initialize the submit button routine, which prevents multiple submissions
        if (!$options->readonly) 
            $this->page->requires->js_init_call('M.core_question_engine.init_submit_button', array($attributes['id'], $qa->get_slot()));
        
        return $output;
    }



}
