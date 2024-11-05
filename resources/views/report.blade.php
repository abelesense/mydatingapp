<form action="{{ route('report.submit', ['user' => $user->id]) }}" method="POST">
    @csrf
    <h2>Report {{ $user->username }}</h2>

    <label for="reason">Reason for Complaint:</label>
    <input type="text" id="reason" name="reason" required>

    <label for="description">Description (optional):</label>
    <textarea id="description" name="description"></textarea>

    <button type="submit">Submit Report</button>
</form>
