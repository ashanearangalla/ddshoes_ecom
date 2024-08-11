using ddApp.Models;
using ddApp.Interfaces;
using System.Collections.Generic;
using System.Linq;
using ddApp.DAL;

namespace ddApp.Repository
{
    public class UserRepository : IUserRepository
    {
        private readonly DataContext _context;

        public UserRepository(DataContext context)
        {
            _context = context;
        }

        public ICollection<User> GetUsers()
        {
            return _context.Users.ToList();
        }

        public User GetUser(int id)
        {
            return _context.Users.Find(id);
        }

        public bool UserExists(int id)
        {
            return _context.Users.Any(u => u.UserID == id);
        }

        public int CreateUser(User user)
        {
            // Add the user to the context
            _context.Users.Add(user);

            // Save changes and check if the operation was successful
            if (Save())
            {
                // Return the ID of the newly created user
                return user.UserID;
            }

            // Return -1 if the save operation failed
            return -1;
        }
        public bool UpdateUser(User user)
        {
            _context.Users.Update(user);
            return Save();
        }

        public bool DeleteUser(User user)
        {
            _context.Users.Remove(user);
            return Save();
        }

        public bool Save()
        {
            // Save changes and return whether any rows were affected
            return _context.SaveChanges() > 0;
        }

        public User GetUserByUsername(string username)
        {
            return _context.Users.FirstOrDefault(u => u.Username == username);
        }

        public bool CheckPassword(User user, string password)
        {
            return user.Password == password;
        }
    }
}
