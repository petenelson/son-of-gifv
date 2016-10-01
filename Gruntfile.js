module.exports = function( grunt ) {

	grunt.initConfig( {
		pkg:    grunt.file.readJSON( 'package.json' ),

		makepot: {
			target: {
				options: {
					type:        'wp-plugin',
					mainFile:    'son-of-gifv.php'
				}
			}
		},

		dirs: {
			lang: 'languages',
		},

		potomo: {
			dist: {
				options: {
					poDel: false
				},
				files: [{
					expand: true,
					cwd: '<%= dirs.lang %>',
					src: ['*.po'],
					dest: '<%= dirs.lang %>',
					ext: '.mo',
					nonull: true
				}]
			}
		},

		wp_readme_to_markdown: {
			options: {
				screenshot_url: "https://raw.githubusercontent.com/petenelson/son-of-gifv/master/assets/{screenshot}.png",
				},
			your_target: {
				files: {
					'README.md': 'readme.txt'
				}
			},
		},

		insert: {
			options: {},
			badges: {
				src: "badges.md",
				dest: "README.md",
				match: "**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  "
			},
		},

		clean:  {
			wp: [ "release" ]
		},

		phplint: {
			options: {
				limit: 10,
				stdout: true,
				stderr: true
			},
			files: [
				'admin/**/*.php',
				'includes/*.php',
				'*.php'
			]
		},

		phpunit: {
			'default': {
				cmd: 'phpunit',
				args: ['-c', 'phpunit.xml.dist']
			},
		},

		copy:   {
			// create release for WordPress repository
			wp: {
				files: [

					// directories
					{ expand: true, src: ['admin/**'], dest: 'release/son-of-gifv' },
					{ expand: true, src: ['includes/**'], dest: 'release/son-of-gifv' },
					{ expand: true, src: ['languages/*.pot'], dest: 'release/son-of-gifv' },
					{ expand: true, src: ['languages/*.mo'], dest: 'release/son-of-gifv' },

					// root dir files
					{
						expand: true,
						src: [
							'*.php',
							'readme.txt',
							],
						dest: 'release/son-of-gifv'
					}

				]
			} // wp

		}

	} ); // grunt.initConfig


	// Load tasks
	var tasks = [
		'grunt-contrib-clean',
		'grunt-contrib-copy',
		'grunt-wp-i18n',
		'grunt-potomo',
		'grunt-wp-readme-to-markdown',
		'grunt-insert',
		'grunt-phplint'
		];

	for	( var i = 0; i < tasks.length; i++ ) {
		grunt.loadNpmTasks( tasks[ i ] );
	};


	// Register tasks

	grunt.registerTask( 'test', [ 'phplint', 'phpunit' ] );

	grunt.registerTask( 'readme', ['wp_readme_to_markdown' ] );

	// create release for WordPress repository
	grunt.registerTask( 'wp', [ 'clean', 'copy' ] );

	grunt.registerMultiTask('phpunit', 'Runs PHPUnit tests', function() {
		grunt.util.spawn({
			cmd: this.data.cmd,
			args: this.data.args,
			opts: {stdio: 'inherit'}
		}, this.async());
	});

	grunt.util.linefeed = '\n';

};
