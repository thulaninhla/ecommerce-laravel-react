<footer class="relative py-10 mt-10 text-gray-800 bg-gray-100 border-t">
    <div class="grid grid-cols-1 gap-8 px-4 mx-auto max-w-7xl md:grid-cols-4">

        <!-- Contact Info -->
        <div>
            <h4 class="mb-4 text-xl font-semibold">Contact Us</h4>
            <p>Email: <a href="mailto:info@shopnow.com" class="text-blue-600 hover:underline">info@shopnow.com</a></p>
            <p>Phone: +1 (123) 456-7890</p>
            <p>Address: 123 Market Street, City, Country</p>
        </div>

        <!-- Quick Links -->
        <div>
            <h4 class="mb-4 text-xl font-semibold">Quick Links</h4>
            <ul class="space-y-2">
                <li><a href="{{ route('shop.index') }}" class="hover:text-blue-600">Home</a></li>
                <li><a href="{{ route('cart.index') }}" class="hover:text-blue-600">Cart</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-blue-600">Login</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-blue-600">Register</a></li>
            </ul>
        </div>

        <!-- Social Media -->
        <div>
            <h4 class="mb-4 text-xl font-semibold">Follow Us</h4>
            <div class="flex space-x-4">
                <a href="#" class="text-gray-600 hover:text-blue-600"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="text-gray-600 hover:text-sky-500"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-gray-600 hover:text-pink-500"><i class="fab fa-instagram fa-lg"></i></a>
                <a href="#" class="text-gray-600 hover:text-blue-700"><i class="fab fa-linkedin fa-lg"></i></a>
            </div>
        </div>

        <!-- Newsletter -->
        <div>
            <h4 class="mb-4 text-xl font-semibold">Newsletter</h4>
            <p class="mb-2 text-sm text-gray-600">Stay updated with our latest products.</p>
            <form>
                <input type="email" placeholder="Your email"
                    class="w-full px-3 py-2 mb-2 border rounded focus:outline-none focus:ring focus:border-blue-400">
                <button type="submit"
                    class="w-full px-3 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                    Subscribe
                </button>
            </form>
        </div>
    </div>

    <!-- Copyright -->
    <div class="mt-8 text-sm text-center text-gray-500">
        © {{ date('Y') }} ShopNow. All rights reserved.
    </div>

    <!-- Back to Top Button -->
    <button onclick="scrollToTop()"
        class="fixed p-3 text-white bg-blue-600 rounded-full shadow-lg bottom-6 right-6 hover:bg-blue-700 focus:outline-none">
        ↑
    </button>

    <script>
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</footer>
