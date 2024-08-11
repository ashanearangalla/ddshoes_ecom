using ddApp.Models;
using Microsoft.EntityFrameworkCore;
using System.Collections.Generic;

namespace ddApp.Interfaces
{
    public interface IUserRepository
    {
        ICollection<User> GetUsers();
        User GetUser(int id);
        bool UserExists(int id);
        int CreateUser(User user);
        bool UpdateUser(User user);
        bool DeleteUser(User user);

        public User GetUserByUsername(string username);

        public bool CheckPassword(User user, string password);
        bool Save();
    }
}