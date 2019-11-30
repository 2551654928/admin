@extends('layouts.app')

@section('title', '十年之约')

@section('content')
    <!-- Main -->
    <article id="main">

        <header class="special container">
            <span class="icon solid fa-file-text"></span>
            <h2><strong>{{ $article->title }}</strong></h2>
            <p>{{  }}</p>
        </header>

        <!-- One -->
        <section class="wrapper style4 container">

            <!-- Content -->
            <div class="content">
                <section>
                    <a href="#" class="image featured"><img src="images/pic04.jpg" alt="" /></a>
                    <header>
                        <h3>Dolore Amet Consequat</h3>
                    </header>
                    <p>Aliquam massa urna, imperdiet sit amet mi non, bibendum euismod est. Curabitur mi justo, tincidunt vel eros ullamcorper, porta cursus justo. Cras vel neque eros. Vestibulum diam quam, mollis at consectetur non, malesuada quis augue. Morbi tincidunt pretium interdum. Morbi mattis elementum orci, nec dictum massa. Morbi eu faucibus massa. Aliquam massa urna, imperdiet sit amet mi non, bibendum euismod est. Curabitur mi justo, tincidunt vel eros ullamcorper, porta cursus justo. Cras vel neque eros. Vestibulum diam.</p>
                    <p>Vestibulum diam quam, mollis at consectetur non, malesuada quis augue. Morbi tincidunt pretium interdum. Morbi mattis elementum orci, nec dictum porta cursus justo. Quisque ultricies lorem in ligula condimentum, et egestas turpis sagittis. Cras ac nunc urna. Nullam eget lobortis purus. Phasellus vitae tortor non est placerat tristique. Sed id sem et massa ornare pellentesque. Maecenas pharetra porta accumsan. </p>
                    <p>In vestibulum massa quis arcu lobortis tempus. Nam pretium arcu in odio vulputate luctus. Suspendisse euismod lorem eget lacinia fringilla. Sed sed felis justo. Nunc sodales elit in laoreet aliquam. Nam gravida, nisl sit amet iaculis porttitor, risus nisi rutrum metus, non hendrerit ipsum arcu tristique est.</p>
                </section>
            </div>

        </section>

        <!-- Two -->
        <section class="wrapper style4 special container">

            <!-- Content -->
            <div class="content">
                <form>
                    <div class="row gtr-50">
                        <div class="col-6 col-12-mobile">
                            <input type="text" name="name" placeholder="Name">
                        </div>
                        <div class="col-6 col-12-mobile">
                            <input type="text" name="email" placeholder="Email">
                        </div>
                        <div class="col-12">
                            <input type="text" name="subject" placeholder="Subject">
                        </div>
                        <div class="col-12">
                            <textarea name="message" placeholder="Message" rows="7"></textarea>
                        </div>
                        <div class="col-12">
                            <ul class="buttons">
                                <li><input type="submit" class="special" value="Send Message"></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>

        </section>
    </article>
@endsection
