namespace ddApp.Models
{
    public class User
    {
        public int UserID { get; set; }
        public string Username { get; set; }
        public string Password { get; set; } 
        public string Role { get; set; } 

        
        public ICollection<Order> Orders { get; set; }
        public ICollection<SubStock> SubStocks { get; set; }

    
        public Outlet Outlet { get; set; }
        public Partner Partner { get; set; }
    }
}
