export default async function handler(req, res) {
  const GITHUB_API =
    "https://api.github.com/repos/pnkproductions7-source/PNK/contents/src/_data/projects";

  try {
    // Get list of files from GitHub
    const response = await fetch(GITHUB_API);

    if (!response.ok) {
      return res.status(404).json({ error: "Projects not found" });
    }

    const files = await response.json();

    // Filter out template files (ones with {{slug title}})
    const projectFiles = files.filter(
      (f) => f.name.endsWith(".json") && !f.name.includes("{{"),
    );

    // Fetch and parse each project file
    const projects = await Promise.all(
      projectFiles.map(async (file) => {
        try {
          const fileResponse = await fetch(file.url);
          const fileData = await fileResponse.json();
          const content = JSON.parse(atob(fileData.content));
          return content;
        } catch (e) {
          return null;
        }
      }),
    );

    // Filter out nulls
    const validProjects = projects.filter((p) => p !== null);

    res.setHeader("Cache-Control", "public, max-age=300"); // 5 min cache
    return res.json(validProjects);
  } catch (error) {
    console.error("Error:", error);
    return res.status(500).json({ error: "Failed to fetch projects" });
  }
}
