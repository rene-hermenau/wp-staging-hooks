<?php

/*
  Plugin Name: WP Staging Hooks
  Plugin URI:
  Description: Extend WP Staging by using actions and filters.
  Author: WP Staging
  Version: 0.0.1
  Author URI: https://wp-staging.com
 */

/*
 * Copyright (c) 2019 WP Staging. All rights reserved.
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 */

class wpstagingHooks {

    /**
     * Uncomment the actions / filters below to activate them
     */
    function __construct() {


        // Run after successfull cloning
        //add_action( 'wpstg_cloning_complete', array($this, 'cloningComplete'), 10 );

        // Run after successfull pushing
        add_action( 'wpstg_pushing_complete', array($this, 'pushingComplete') );

        // Exclude Tables From Search & Replace operation / Cloning and Pushing
        //add_action( 'wpstg_searchreplace_excl_tables', array($this, 'excludeTablesSR'), 10 );

        // Cloning: Exclude Rows From Search & Replace in wp_options
        //add_action( 'wpstg_clone_searchreplace_excl_rows', array($this, 'excludeRowsSR'), 10 );

        // Cloning: Exclude Rows From Search & Replace in wp_options
        //add_action( 'wpstg_clone_searchreplace_excl', array($this, 'excludeStringsSR'), 10 );

        // Cloning: Change Search & Replace Parameters
        //add_action( 'wpstg_clone_searchreplace_params', array($this, 'setSRparams'), 10 );

        // Cloning: Exclude Folders
        //add_action( 'wpstg_clone_excl_folders', array($this, 'excludeFolders'), 10 );

        // Cloning: Do not Modify Table Prefix from option_name in wp_options
        //add_action( 'wpstg_excl_option_name_custom', array($this, 'wpstg_excl_option_name_custom'), 10 );

        // Pushing: Change Search & Replace parameters
        //add_action( 'wpstg_push_searchreplace_params', array($this, 'wpstg_push_custom_params'), 10 );

        // Pushing: Exclude tables from pushing
        //add_action( 'wpstg_push_excluded_tables', array($this, 'wpstg_push_excluded_tables'), 10 );

        // Pushing: Exclude folders from pushing
        //add_action( 'wpstg_push_excl_folders_custom', array($this, 'wpstg_push_directories_excl'), 10 );

        // Pushing: Preserve data in wp_options and exclude it from pushing
        //add_action( 'wpstg_preserved_options', array($this, 'wpstg_push_options_excl'), 10 );
    }


    /**
     * Send out an email when the cloning proces has been finished successfully
     */
    public function cloningComplete() {
        wp_mail( 'test@example.com', 'WP Staging cloning process has been finished', 'body sample text' );
    }

    /**
     * Send out an email when the pushing proces has been finished successfully
     */
    public function pushingComplete() {
            wp_mail( 'test@example.com', 'WP Staging cloning process has been finished', 'body sample text' );
    }

    /**
     * Exclude Tables From Search & Replace operation
     */
    public function excludeTablesSR( $tables ) {
        $addTables = array('_posts', '_postmeta');
        return array_merge( $tables, $addTables );
    }

    /**
     * Exclude Tables From Search & Replace operation
     */
    public function excludeRowsSR( $default ) {
        $rows = array('siteurl', 'home');
        return array_merge( $default, $rows );
    }

    /**
     * Exclude Tables From Search & Replace operation
     */
    public function excludeStringsSR() {
        return array('blog.localhost.com', 'blog1.localhost.com');
    }

    /**
     * Cloning: Change Search & Replace Parameters
     */
    public function setSRparams( $args ) {
        // Default values - Can be changed
        $args['search_for']       = array_merge(
                $args['search_for'], array('SEARCHSTRING', 'SEARCHSTRING2')
        );
        $args['replace_with']     = array_merge(
                $args['replace_with'], array('REPLACESTRING', 'REPLACESTRING2')
        );
        $args['replace_guids']    = 'off';
        $args['dry_run']          = 'off';
        $args['case_insensitive'] = false;
        $args['replace_guids']    = 'off';
        $args['replace_mails']    = 'off';
        $args['skip_transients']  = 'on';
        return $args;
    }

    /**
     * Cloning: Exclude Folders
     */
    public function excludeFolders( $defaultFolders ) {
        $folders = array('wordpress-seo', 'custom-folder');
        return array_merge( $defaultFolders, $folders );
    }

    /**
     * Excluded folders relative to the wp-content folder when cloning multisites
     */
    public function multisiteExcludeFoldersCloning( $defaultFolders ) {
        $folders = array('plugins/wordpress-seo', 'themes/custom-folder');
        return array_merge( $defaultFolders, $folders );
    }

    /**
     * Cloning: Do not Modify Table Prefix for particular rows in option_name
     */
    public function wpstg_excl_option_name_custom( $args ) {
        $cols = array('wp_mail_smtp', 'wp_mail_smtp_version');
        return array_merge( $args, $cols );
    }

    /**
     * Pushing: Change Search & Replace parameters
     */
    public function wpstg_push_custom_params( $args ) {
        // Default values - Can be changed
        $args['search_for']       = array_merge(
                $args['search_for'], array('SEARCHSTRING', 'SEARCHSTRING2')
        );
        $args['replace_with']     = array_merge(
                $args['replace_with'], array('REPLACESTRING', 'REPLACESTRING2')
        );
        $args['replace_guids']    = 'off';
        $args['dry_run']          = 'off';
        $args['case_insensitive'] = false;
        $args['replace_guids']    = 'off';
        $args['replace_mails']    = 'off';
        $args['skip_transients']  = 'on';
        return $args;
    }

    /**
     * Pushing: Change Search & Replace parameters
     */
    function wpstg_push_excluded_tables( $tables ) {
        $customTables = array('_options', '_posts');
        return array_merge( $tables, $customTables );
    }

    /**
     * Pushing: Exclude folders from pushing
     */
    function wpstg_push_directories_excl( $default ) {
        $dirs = array('custom-folder', 'custom-folder2');
        return array_merge( $default, $dirs );
    }

    /**
     * Pushing: Preserve data in wp_options and exclude it from pushing
     */
    function wpstg_push_options_excl( $options ) {
        $options[] = 'siteurl';
        return $options;
    }

}

    new wpstagingHooks();


