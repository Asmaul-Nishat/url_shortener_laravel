import { createPopper } from '@popperjs/core';

import './bootstrap';

import Alpine from 'alpinejs';

import ApexCharts from 'apexcharts';

import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

import { Calendar } from 'fullcalendar';


/*
|--------------------------------------------------------------------------
| Global Variables
|--------------------------------------------------------------------------
*/

window.Alpine = Alpine;

window.createPopper = createPopper;

window.ApexCharts = ApexCharts;

window.flatpickr = flatpickr;

window.FullCalendar = Calendar;


/*
|--------------------------------------------------------------------------
| Start Alpine
|--------------------------------------------------------------------------
*/

Alpine.start();


/*
|--------------------------------------------------------------------------
| DOM Loaded
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {


    /*
    |--------------------------------------------------------------------------
    | Map
    |--------------------------------------------------------------------------
    */

    if (document.querySelector('#mapOne')) {

        import('./components/map')
            .then(module => {

                module.initMap();

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Chart One
    |--------------------------------------------------------------------------
    */

    if (document.querySelector('#chartOne')) {

        import('./components/chart/chart-1')
            .then(module => {

                module.initChartOne();

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Chart Two
    |--------------------------------------------------------------------------
    */

    if (document.querySelector('#chartTwo')) {

        import('./components/chart/chart-2')
            .then(module => {

                module.initChartTwo();

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Chart Three
    |--------------------------------------------------------------------------
    */

    if (document.querySelector('#chartThree')) {

        import('./components/chart/chart-3')
            .then(module => {

                module.initChartThree();

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Chart Six
    |--------------------------------------------------------------------------
    */

    if (document.querySelector('#chartSix')) {

        import('./components/chart/chart-6')
            .then(module => {

                module.initChartSix();

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Chart Eight
    |--------------------------------------------------------------------------
    */

    if (document.querySelector('#chartEight')) {

        import('./components/chart/chart-8')
            .then(module => {

                module.initChartEight();

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Chart Thirteen
    |--------------------------------------------------------------------------
    */

    if (document.querySelector('#chartThirteen')) {

        import('./components/chart/chart-13')
            .then(module => {

                module.initChartThirteen();

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Calendar
    |--------------------------------------------------------------------------
    */

    if (document.querySelector('#calendar')) {

        import('./components/calendar-init')
            .then(module => {

                module.calendarInit();

            });

    }

});