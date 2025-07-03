<!-- Footer -->
<footer class="bg-stats4sd-grey py-12">
    <div class="max-w-screen-lg 2xl:max-w-screen-xl 3xl:max-w-screen-2xl px-12 sm:px-24 md:px-16 2xl:px-24  mx-auto ">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-12 text-white text-sm">
            <div class="md:col-span-4">
                <p class="font-bold">© Statistics for Sustainable Development {{ date("Y") }}</p>
                <p class="pt-4">9 Castle Street, Reading, RG1 7SB</p>
                <p>{{ t("Company Registered in England & Wales Number") }} - 10168747</p>

            </div>
            <div class="md:col-span-2">
                <p class="font-bold">{{ t("Contact") }}</p>
                <p>{{ t("Tel") }}: +44 (0)118 959 9949<br>
                    {{ t("Email") }}:
                    <a href="mailto:hello@stats4sd.org" class="hover:underline">hello@stats4sd.org</a>
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="https://www.linkedin.com/company/statistics-for-sustainable-development">
                        <img src="{{ asset('/images/linkedin_logo.png') }}" class="w-8 h-8">
                    </a>
                    <a href="https://www.youtube.com/channel/UCs7EU95YMjhvNozJKCD92xQ">
                        <img src="{{ asset('/images/youtube_logo.png') }}" class="w-8 h-8">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
