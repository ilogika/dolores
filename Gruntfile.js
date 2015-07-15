'use strict';

module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    browserify: {
      options: {
        debug: true,
        transform: ['reactify', 'debowerify']
      },

      default: {
        src: ['src/js/main.js'],
        dest: 'build/script.js'
      }
    },

    closureCompiler: {
      options: {
        compilerFile: 'node_modules/google-closure-compiler/compiler.jar',
        compilerOpts: {
          compilation_level: 'SIMPLE_OPTIMIZATIONS',
          language_in: 'ECMASCRIPT6',
          language_out: 'ECMASCRIPT5'
        }
      },

      default: {
        src: 'build/script.js',
        dest: 'build/script.gcc.js'
      }
    },

    compass: {
      default: {
        options: {
          banner: "/*\n" +
            "Theme Name: Dolores\n" +
            "Theme URI: http://dolores/\n" +
            "Author: Tiago Madeira\n" +
            "Author URI: http://tiagomadeira.com/\n" +
            "Description: dev stylesheet\n" +
            "Version: 0.0.1\n" +
            "*/\n",
          specify: 'src/css/**/*.scss',
          sassDir: 'src/css',
          cssDir: 'build',
          fontsDir: 'static/fonts',
          imagesDir: 'static/images',
          importPath: [
            'bower_components/breakpoint-sass/stylesheets',
            'bower_components/singularity/stylesheets'
          ]
        }
      }
    },

    copy: {
      devtheme: {
        cwd: 'build/',
        dest: '/var/www/dolores/wp-content/themes/dolores/',
        expand: true,
        src: '**',
        timestamp: true
      },

      php: {
        cwd: 'src/php/',
        dest: 'build/',
        expand: true,
        src: '**',
        timestamp: true
      },

      static: {
        dest: 'build/',
        expand: true,
        src: 'static/**',
        timestamp: true
      }
    },

    cssmin: {
      options: {
        roundingPrecision: -1
      },

      default: {
        files: {
          'build/style.min.css': ['build/style.css']
        }
      }
    },

    concurrent: {
      options: {
        debounceDelay: 250,
        forever: false,
        logConcurrentOutput: true,
        spawn: false
      },

      watch: {
        tasks: ['watch:build', 'watch:css', 'watch:js', 'watch:php', 'watch:static']
      }
    },

    eslint: {
      options: {
        envs: ['browser', 'node']
      },

      dev: {
        options: {
          force: true
        },

        files: {
          src: ['src/**/*.js']
        }
      },

      prod: {
        options: {
          force: false
        },

        files: {
          src: ['src/**/*.js']
        }
      }
    },

    sass: {
      default: {
        files: {
          'build/style.css': 'src/css/style.scss'
        }
      }
    },

    uglify: {
      default: {
        files: {
          'build/script.min.js': 'build/script.gcc.js'
        }
      }
    },

    watch: {
      options: {
        atBegin: true,
        spawn: false
      },

      build: {
        files: 'build/**/*',
        tasks: ['copy:devtheme']
      },

      css: {
        files: 'src/css/**/*.scss',
        tasks: ['compass']
      },

      js: {
        files: 'src/js/**/*.js',
        tasks: ['eslint:dev', 'browserify']
      },

      php: {
        files: 'src/php/**/*.php',
        tasks: ['copy:php']
      },

      static: {
        files: 'static/**/*',
        tasks: ['copy:static']
      }
    }
  });

  grunt.loadNpmTasks('grunt-browserify');
  grunt.loadNpmTasks('grunt-closure-tools');
  grunt.loadNpmTasks('grunt-concurrent');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-eslint');

  grunt.registerTask(
    'dev',
    [
      'concurrent:watch'
    ]
  );

  grunt.registerTask(
    'prod',
    [
      // JS
      'eslint:prod',
      'browserify',
      'closureCompiler',
      'uglify',

      // CSS
      'compass',
      'cssmin',

      // PHP
      'copy:php',

      // Static
      'copy:static',
    ]
  );

  grunt.registerTask('default', ['dev']);
};