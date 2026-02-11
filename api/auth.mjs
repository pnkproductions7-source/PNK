export default function handler(req, res) {
  const CLIENT_ID = process.env.GITHUB_CLIENT_ID;
  // Redirects the user to GitHub to authorize the app
  const url = `https://github.com/login/oauth/authorize?client_id=${CLIENT_ID}&scope=repo,user`;
  res.redirect(url);
}
