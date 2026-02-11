export default function handler(req, res) {
  const GITHUB_CLIENT_ID = process.env.GITHUB_CLIENT_ID;
  // Redirect to GitHub's OAuth login page
  const url = `https://github.com/login/oauth/authorize?client_id=${GITHUB_CLIENT_ID}&scope=repo,user`;
  res.redirect(url);
}
