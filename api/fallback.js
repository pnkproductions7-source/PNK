export default async function handler(req, res) {
  // 1. Get the temporary 'code' sent by GitHub
  const { code } = req.query;

  // 2. These are the secrets you saved in your Vercel Dashboard
  const { GITHUB_CLIENT_ID, GITHUB_CLIENT_SECRET } = process.env;

  try {
    // 3. Exchange the temporary code for a permanent access token
    const response = await fetch(
      "https://github.com/login/oauth/access_token",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({
          client_id: GITHUB_CLIENT_ID,
          client_secret: GITHUB_CLIENT_SECRET,
          code,
        }),
      },
    );

    const data = await response.json();

    // 4. Send the token back to your Admin panel and close the popup
    res.send(`
      <script>
        (function() {
          function receiveMessage(e) {
            window.opener.postMessage(
              'authorization:github:success:${JSON.stringify({
                token: data.access_token,
                provider: "github",
              })}',
              e.origin
            );
          }
          window.addEventListener("message", receiveMessage, false);
          window.opener.postMessage("authorizing:github", "*");
        })()
      </script>
    `);
  } catch (error) {
    res.status(500).send("Authentication failed: " + error.message);
  }
}
