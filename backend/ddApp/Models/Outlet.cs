namespace ddApp.Models
{
    public class Outlet
    {
        public int OutletID { get; set; }
        public string OutletName { get; set; }
        public string Location { get; set; }

        public int UserID { get; set; }
        public User User { get; set; }

 
        public ICollection<SubStock> StockDetails { get; set; }
    }
}
