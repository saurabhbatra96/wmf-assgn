create table if not exists currency_rates (
	currency varchar(10),
	conv_rate float not null,
	primary key (currency)
);