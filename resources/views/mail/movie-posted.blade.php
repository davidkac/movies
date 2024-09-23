<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; padding: 20px;">
    <h2 style="text-align: center; color: #007BFF;">
        New Rating on Your Movie!
    </h2>

    <p style="font-size: 16px;">
        Hello <strong>{{ $movie->user->name }}</strong>,
    </p>

    <p style="font-size: 16px;">
        <strong>{{ $userName }}</strong> has rated your movie <strong>{{ $movie->title }}</strong> with a grade of <strong>{{ $rating }}</strong>.
    </p>

    <p style="font-size: 16px;">
        You can view your movie by clicking the link below:
    </p>

    <p style="text-align: center;">
        <a href="{{ url('/movies/' . $movie->id) }}" style="display: inline-block; padding: 12px 24px; font-size: 16px; color: white; background-color: #007BFF; text-decoration: none; border-radius: 5px;">
            View Your Movie
        </a>
    </p>
</div>
