🧑 Basic Personal Information
Website Entry Unique ID
Full Name
Profile Picture (optional)
Date of Birth
Gender (optional)
Nationality
Country of Residence

📱 Contact Information
Email Address (required for login & communication)
Phone Number (with OTP verification)
WhatsApp / Telegram ID (optional)
Physical Address (KYC purposes)

🔒 Account Credentials
Username
Password (stored securely using hashing)
Two-Factor Authentication (2FA) method
SMS / Email / Authenticator App
Security Questions & Answers (for recovery)

🧾 Identity Verification (KYC)
Especially important if you are dealing with funds or financial services
Government-issued ID (Passport / National ID / Driver’s License)
Proof of Address (Utility Bill / Bank Statement)
Live Selfie Upload (for facial recognition / match with ID)
Tax ID or National Insurance Number (if needed for compliance)

👨‍💻 Platform Usage Preferences
Language Preference
Time Zone
Notification Preferences (Email / SMS / Push)
Dark Mode / Light Mode

📁 Documents & Agreements
Partnership agreement(Upload)
Uploaded Agreements / Contracts (Terms of Use, Risk Disclosure)
NDA or Service Agreement files (Upload)

🔄 Account Actions
Change Password
Deactivate / Delete Account
Export Personal Data (GDPR compliance)
Login History / Sessions
Request new Website Entry Unique ID



<!--  -->
@extends('layouts.app')

@section('content')
 <!-- bread crumb -->
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <div class="grow">
        <h5 class="text-16">Ecommerce</h5>
    </div>
    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
            <a href="#!" class="text-slate-400 dark:text-zink-200">Dashboards</a>
        </li>
        <li class="text-slate-700 dark:text-zink-100">
            Ecommerce
        </li>
    </ul>
</div>
<!-- bread crumb End -->

<!-- icon switch start-->
 <div class="flex items-center">
    <div class="relative inline-block w-10 align-middle transition duration-200 ease-in ltr:mr-2 rtl:ml-2">
        <input type="checkbox" name="customIconSwitch" id="customIconSwitch" class="absolute block size-5 transition duration-300 ease-linear border-2 border-slate-200 dark:border-zink-500 rounded-full appearance-none cursor-pointer bg-white/80 dark:bg-zink-600 peer/published checked:bg-white dark:checked:bg-white ltr:checked:right-0 rtl:checked:left-0 checked:bg-none checked:border-custom-500 dark:checked:border-custom-500 arrow-none after:absolute after:text-slate-500 dark:after:text-zink-200 after:content-['\eb99'] after:text-xs after:inset-0 after:flex after:items-center after:justify-center after:font-remix after:leading-none checked:after:text-custom-500 dark:checked:after:text-custom-500 checked:after:content-['\eb7b']" checked>
        <label for="customIconSwitch" class="block h-5 overflow-hidden duration-300 ease-linear border rounded-full cursor-pointer cursor-pointertransition border-slate-200 dark:border-zink-500 bg-slate-200 dark:bg-zink-600 peer-checked/published:bg-custom-500 peer-checked/published:border-custom-500"></label>
    </div>
    <label for="customIconSwitch" class="inline-block text-base font-medium cursor-pointer">Custom Switch</label>
</div>
<!-- icon switch end-->

   <select class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" data-choices name="choices-single-default" id="choices-single-default">
        <option value="">This is a placeholder</option>
        <option value="Choice 1">Choice 1</option>
        <option value="Choice 2">Choice 2</option>
        <option value="Choice 3">Choice 3</option>
    </select>

       <input class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="choices-text-remove-button" data-choices data-choices-limit="3" data-choices-removeItem type="text" value="Task-1">

         <select class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="choices-multiple-remove-button" multiple>
            <option value="Choice 1" selected>Choice 1</option>
            <option value="Choice 2">Choice 2</option>
            <option value="Choice 3">Choice 3</option>
            <option value="Choice 4">Choice 4</option>
        </select>


          <button type="button" data-modal-target="showModal" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20 add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="align-bottom ri-add-line me-1"></i> Add Customer</button>
                                <button type="button" class="text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-custom-400/20" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>

                                <!--  -->
                                   <h5 class="mb-4 text-15">Default Spinner</h5>
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="inline-block border-2 rounded-full size-8 animate-spin border-l-transparent border-custom-500"></div>
                                <div class="inline-block border-2 border-green-500 rounded-full size-8 animate-spin border-l-transparent"></div>
                                <div class="inline-block border-2 border-orange-500 rounded-full size-8 animate-spin border-l-transparent"></div>
                                <div class="inline-block border-2 rounded-full size-8 animate-spin border-l-transparent border-sky-500"></div>
                                <div class="inline-block border-2 border-yellow-500 rounded-full size-8 animate-spin border-l-transparent"></div>
                                <div class="inline-block border-2 border-red-500 rounded-full size-8 animate-spin border-l-transparent"></div>
                                <div class="inline-block border-2 border-purple-500 rounded-full size-8 animate-spin border-l-transparent"></div>
                                <div class="inline-block border-2 rounded-full size-8 animate-spin border-l-transparent border-slate-400 dark:border-zink-500 dark:border-l-transparent"></div>
                                <div class="inline-block border-2 rounded-full size-8 animate-spin border-l-transparent border-slate-900 dark:border-zink-200 dark:border-l-transparent"></div>
                            </div>

                             <td class="px-3.5 py-2.5 first:pl-5 last:pr-5"><span class="px-2.5 py-0.5 text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent inline-flex items-center status"><i data-lucide="check-circle" class="size-3 mr-1.5"></i> Verified</span></td>

                              <td class="px-3.5 py-2.5 first:pl-5 last:pr-5"><span class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent status"><i data-lucide="loader" class="size-3 mr-1.5"></i> Waiting</span></td>

                                       <td class="px-3.5 py-2.5 first:pl-5 last:pr-5"><span class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent status"><i data-lucide="x" class="size-3 mr-1.5"></i> Rejected</span></td>
                                <!--  -->

 <div class="card">
                    <div class="card-body">
                        <h6 class="mb-4 text-15">Bordered Table</h6>
                        <table id="borderedTable" class="bordered group" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                    <td>2011-04-25</td>
                                    <td>$320,800</td>
                                </tr>
                                <tr>
                                    <td>Garrett Winters</td>
                                    <td>Accountant</td>
                                    <td>Tokyo</td>
                                    <td>63</td>
                                    <td>2011-07-25</td>
                                    <td>$170,750</td>
                                </tr>
                                <tr>
                                    <td>Ashton Cox</td>
                                    <td>Junior Technical Author</td>
                                    <td>San Francisco</td>
                                    <td>66</td>
                                    <td>2009-01-12</td>
                                    <td>$86,000</td>
                                </tr>
                                <tr>
                                    <td>Cedric Kelly</td>
                                    <td>Senior Javascript Developer</td>
                                    <td>Edinburgh</td>
                                    <td>22</td>
                                    <td>2012-03-29</td>
                                    <td>$433,060</td>
                                </tr>
                                <tr>
                                    <td>Airi Satou</td>
                                    <td>Accountant</td>
                                    <td>Tokyo</td>
                                    <td>33</td>
                                    <td>2008-11-28</td>
                                    <td>$162,700</td>
                                </tr>
                                <tr>
                                    <td>Brielle Williamson</td>
                                    <td>Integration Specialist</td>
                                    <td>New York</td>
                                    <td>61</td>
                                    <td>2012-12-02</td>
                                    <td>$372,000</td>
                                </tr>
                                <tr>
                                    <td>Herrod Chandler</td>
                                    <td>Sales Assistant</td>
                                    <td>San Francisco</td>
                                    <td>59</td>
                                    <td>2012-08-06</td>
                                    <td>$137,500</td>
                                </tr>
                                <tr>
                                    <td>Rhona Davidson</td>
                                    <td>Integration Specialist</td>
                                    <td>Tokyo</td>
                                    <td>55</td>
                                    <td>2010-10-14</td>
                                    <td>$327,900</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!--end card-->

<div class="grid grid-cols-12 2xl:grid-cols-12 gap-x-5">
    
</div>
<!--end grid-->

@endsection
<!--  -->
