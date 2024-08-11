namespace ddApp.Dto
{
    public class UserDto
    {
        public int UserID { get; set; }
        public string Username { get; set; }
        public string Password { get; set; } // Store a hashed version of the password for security
        public string Role { get; set; } // Role could be "Admin", "OutletManager", "Partner"
    }
}
