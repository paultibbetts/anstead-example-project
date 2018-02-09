<?php

use App\Job;

use App\Jobs\AddJobToJobsTable;

Route::get('/', function () {
    return view('demo');
});

Route::post('/jobs', function () {
    AddJobToJobsTable::dispatch();
    return 'success';
});

Route::post('/delete-jobs', function () {
    Job::truncate();
    return 'success';
});

Route::get('/jobs', function () {
    return Job::all();
});
