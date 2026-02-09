<?php
/* gravity form customizations */

// dynamically populate year DDL in tax estimator form - form 33, field 5
add_filter( 'gform_pre_render_34', 'populate_ddl_years' );
function populate_ddl_years ( $form ) {
    if ( empty( $form['id'] ) ) {
        return $form;
    }
    if ( is_admin() ) {
        return $form;
    }
 
    foreach( $form['fields'] as &$field )  {
 
        //NOTE: replace with your checkbox field id
        $field_id = 5;
        if ( $field->id != $field_id ) {
            continue;
        }

        foreach ( $field->choices as &$choice ) {
            if ( $choice['text'] == 'this year' ) { // The string you want to replace
                $choice['text'] = date("Y"); // The new string
            }
            if ( $choice['text'] == 'year-1' ) {
                $choice['text'] = date("Y", strtotime("-1 year")); 
            }
            if ( $choice['text'] == 'year-2' ) { // The string you want to replace
                $choice['text'] = date("Y", strtotime("-2 year")); // The new string
            }
            if ( $choice['text'] == 'year-3' ) { // The string you want to replace
                $choice['text'] = date("Y", strtotime("-3 year")); // The new string
            }
            if ( $choice['text'] == 'year-4' ) { // The string you want to replace
                $choice['text'] = date("Y", strtotime("-4 year")); // The new string
            }
            if ( $choice['text'] == 'year-5+' ) { // The string you want to replace
                $choice['text'] = date("Y", strtotime("-5 year")). " or older"; // The new string
            }
        }

    /*  $choices[1]['text'] =  date("Y")."here"; 
        $choices[] = array( 'text' =>  date("Y", strtotime("-1 year")),  'value' =>   '0.0175' );
        $choices[] = array( 'text' =>  date("Y", strtotime("-2 year")),  'value' =>   '0.0135' );
        $choices[] = array( 'text' =>  date("Y", strtotime("-3 year")),  'value' =>   '0.010' );
        $choices[] = array( 'text' =>  date("Y", strtotime("-4 year")),  'value' =>   '0.0065' );
        $choices[] = array( 'text' =>  date("Y", strtotime("-5 year")). " or older",  'value' =>   '0.0065' ); */
        //$field->choices = $choices;


 
    }
 
    return $form;
}

