var builder = WebApplication.CreateBuilder(args);

// Add services to the container.

builder.Services.AddControllers();
// Learn more about configuring Swagger/OpenAPI at https://aka.ms/aspnetcore/swashbuckle
builder.Services.AddEndpointsApiExplorer();
builder.Services.AddSwaggerGen();

var dbHost = System.Environment.GetEnvironmentVariable("DB_HOST");
var dbName = System.Environment.GetEnvironmentVariable("DB_NAME");
var dbUser = System.Environment.GetEnvironmentVariable("DB_USER");
var dbPass = System.Environment.GetEnvironmentVariable("DB_PASS");

var connectionString = $"Server={dbHost};Database={dbName};User={dbUser};Password={dbPass};";
builder.Services.AddDbContext<ApplicationDbContext>(options => 
{
  options.UseMySql(connectionString, ServerVersion.AutoDetect(connectionString));
});

var app = builder.Build();

// Configure the HTTP request pipeline.
if (app.Environment.IsDevelopment())
{
    app.UseSwagger();
    app.UseSwaggerUI();
}

//app.UseHttpsRedirection();

//app.UseAuthorization();

app.MapControllers();

app.Run();
