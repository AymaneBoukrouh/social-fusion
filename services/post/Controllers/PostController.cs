using Microsoft.AspNetCore.Mvc;
using post.Models;

namespace post.Controllers
{
    [ApiController]
    [Route("/api/posts")]
    public class PostController : ControllerBase
    {
        private readonly ILogger<PostController> _logger;
        private readonly ApplicationDbContext _context;

        public PostController(ILogger<PostController> logger, ApplicationDbContext context)
        {
            _logger = logger;
            _context = context;
        }

        [HttpGet(Name = "GetPosts")]
        public IEnumerable<Post> Get()
        {
            return _context.Posts;
        }

        [HttpGet("{id}", Name = "GetPost")]
        public IActionResult Get(int id)
        {
            var post = _context.Posts.Where(p => p.Id == id).FirstOrDefault();

            if (post == null)
            {
                return NotFound();
            }

            return Ok(post);
        }

        [HttpPost(Name = "CreatePost")]
        public IActionResult Create([FromBody] Post post)
        {
            // create post
            Post newPost = new Post
            {
                Title = post.Title,
                Content = post.Content
            };

            // add post to database
            _context.Posts.Add(newPost);
            _context.SaveChanges();

            // return post
            return CreatedAtRoute("GetPost", new { id = newPost.Id }, newPost);
        }

        [HttpPut("{id}", Name = "UpdatePost")]
        public IActionResult Update(int id, [FromBody] Post post)
        {
            // get post from database
            var postToUpdate = _context.Posts.Where(p => p.Id == id).FirstOrDefault();

            if (postToUpdate == null)
            {
                return NotFound();
            }

            // update post
            postToUpdate.Title = post.Title;
            postToUpdate.Content = post.Content;

            // save changes
            _context.SaveChanges();

            // return post
            return CreatedAtRoute("GetPost", new { id = postToUpdate.Id }, postToUpdate);
        }

        [HttpDelete("{id}", Name = "DeletePost")]
        public IActionResult Delete(int id)
        {
            // get post from database
            var postToDelete = _context.Posts.Where(p => p.Id == id).FirstOrDefault();

            if (postToDelete == null)
            {
                return NotFound();
            }

            // delete post
            _context.Posts.Remove(postToDelete);
            _context.SaveChanges();

            // return post
            return Ok(postToDelete);
        }
    }
}
