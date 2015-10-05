<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Reviews_Loader' ) ) {
    
/** 
 * JKL Reviews Loader
 * 
 * @author Aaron Snowberger
 * @project JKL-Reviews
 * @source http://code.tutsplus.com/tutorials/object-oriented-programming-in-wordpress-building-the-plugin-ii--cms-21105
 */
    
class JKL_Reviews_Loader {
    
    /**
     * Array of actions to hook into
     * @var type 
     */
    protected $actions;
    
    /**
     * Array of filters to hook into
     * @var type 
     */
    protected $filters;
    
    /**
     * CONSTRUCTOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    public function __construct() {
        
        $this->actions = array();
        $this->filters = array();
        
    }
    
    
    /**
     * METHODS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    
    /**
     * More easily add actions to our plugin
     * 
     * @param type $hook
     * @param type $component
     * @param type $callback
     */
    public function add_action( $hook, $component, $callback ) {
        $this->actions = $this->add( $this->actions, $hook, $component, $callback );
    }
    
    /**
     * More easily add filters to our plugin
     * 
     * @param type $hook
     * @param type $component
     * @param type $callback
     */
    public function add_filter( $hook, $component, $callback ) {
        $this->filters = $this->add( $this->filters, $hook, $component, $callbak );
    }
    
    /**
     * Simplify the two above methods by creating a SINGLE method to add filters and actions
     * 
     * @param type $hooks
     * @param type $hook
     * @param type $component
     * @param type $callback
     * @return type
     */
    private function add( $hooks, $hook, $component, $callback ) {
        
        $hooks[] = array(
            'hook'      => $hook,
            'component' => $component,
            'callback'  => $callback
        );
        
        return $hooks;
        
    }
    
    /**
     * Wire up all of the defined hooks (here we register all custom functions with WP)
     */
    public function run() {
        
        foreach ( $this->filters as $hook ) {
            add_filter( $hook[ 'hook' ], array( $hook[ 'component' ], $hook[ 'callback' ] ) );
        }
        
        foreach ( $this->actions as $hook ) {
            add_action( $hook[ 'hook' ], array( $hook[ 'component' ], $hook[ 'callback' ] ) );
        }
    }
    
} // END JKL_Reviews_Loader
} // END if ( ! class_exists( 'JKL_Reviews_Loader' )