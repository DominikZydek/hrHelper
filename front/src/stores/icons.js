import { writable } from 'svelte/store';

// Istniejące ikony (już zweryfikowane)
import EmailOutline from 'svelte-material-icons/EmailOutline.svelte';
import CalendarClock from 'svelte-material-icons/CalendarClock.svelte';
import BellOutline from 'svelte-material-icons/BellOutline.svelte';
import Laptop from 'svelte-material-icons/Laptop.svelte';
import Account from 'svelte-material-icons/Account.svelte';
import AccountGroup from 'svelte-material-icons/AccountGroup.svelte';
import AccountSearch from 'svelte-material-icons/AccountSearch.svelte';
import ChartGantt from 'svelte-material-icons/ChartGantt.svelte';
import MonitorDashboard from 'svelte-material-icons/MonitorDashboard.svelte';
import Database from 'svelte-material-icons/Database.svelte';
import Palette from 'svelte-material-icons/Palette.svelte';
import TestTube from 'svelte-material-icons/TestTube.svelte';
import CogSync from 'svelte-material-icons/CogSync.svelte';
import Bullhorn from 'svelte-material-icons/Bullhorn.svelte';
import CurrencyUsd from 'svelte-material-icons/CurrencyUsd.svelte';
import FileDocumentEdit from 'svelte-material-icons/FileDocumentEdit.svelte';
import Server from 'svelte-material-icons/Server.svelte';
import ShieldAccount from 'svelte-material-icons/ShieldAccount.svelte';
import Cellphone from 'svelte-material-icons/Cellphone.svelte';
import Security from 'svelte-material-icons/Security.svelte';
import Briefcase from 'svelte-material-icons/Briefcase.svelte';
import PencilOutline from 'svelte-material-icons/PencilOutline.svelte';
import ProgressClock from 'svelte-material-icons/ProgressClock.svelte';
import CheckboxMarkedCircleOutline from 'svelte-material-icons/CheckboxMarkedCircleOutline.svelte';
import CloseCircleOutline from 'svelte-material-icons/CloseCircleOutline.svelte';
import BlockHelper from 'svelte-material-icons/BlockHelper.svelte';
import SendOutline from 'svelte-material-icons/SendOutline.svelte';
import HelpCircleOutline from 'svelte-material-icons/HelpCircleOutline.svelte';

// Komunikacja
import MessageText from 'svelte-material-icons/MessageText.svelte';
import MessageTextOutline from 'svelte-material-icons/MessageTextOutline.svelte';
import Phone from 'svelte-material-icons/Phone.svelte';
import Forum from 'svelte-material-icons/Forum.svelte';
import Comment from 'svelte-material-icons/Comment.svelte';
import CommentOutline from 'svelte-material-icons/CommentOutline.svelte';
import Email from 'svelte-material-icons/Email.svelte';

// Kalendarz i czas
import Calendar from 'svelte-material-icons/Calendar.svelte';
import CalendarMonth from 'svelte-material-icons/CalendarMonth.svelte';
import CalendarToday from 'svelte-material-icons/CalendarToday.svelte';
import Clock from 'svelte-material-icons/Clock.svelte';
import ClockOutline from 'svelte-material-icons/ClockOutline.svelte';
import Timer from 'svelte-material-icons/Timer.svelte';
import TimerOutline from 'svelte-material-icons/TimerOutline.svelte';

// Użytkownicy i zespoły
import AccountMultiple from 'svelte-material-icons/AccountMultiple.svelte';
import AccountCircle from 'svelte-material-icons/AccountCircle.svelte';
import AccountOutline from 'svelte-material-icons/AccountOutline.svelte';
import AccountSupervisor from 'svelte-material-icons/AccountSupervisor.svelte';
import AccountTie from 'svelte-material-icons/AccountTie.svelte';
import AccountStar from 'svelte-material-icons/AccountStar.svelte';
import AccountKey from 'svelte-material-icons/AccountKey.svelte';
import AccountCog from 'svelte-material-icons/AccountCog.svelte';
import AccountHardHat from 'svelte-material-icons/AccountHardHat.svelte';

// Analityka i wykresy
import ChartBar from 'svelte-material-icons/ChartBar.svelte';
import ChartLine from 'svelte-material-icons/ChartLine.svelte';
import ChartPie from 'svelte-material-icons/ChartPie.svelte';
import ChartDonut from 'svelte-material-icons/ChartDonut.svelte';
import ChartAreaspline from 'svelte-material-icons/ChartAreaspline.svelte';
import ChartTimeline from 'svelte-material-icons/ChartTimeline.svelte';
import ChartBellCurve from 'svelte-material-icons/ChartBellCurve.svelte';
import Poll from 'svelte-material-icons/Poll.svelte';
import TrendingUp from 'svelte-material-icons/TrendingUp.svelte';
import Finance from 'svelte-material-icons/Finance.svelte';

// Marketing i PR
import Target from 'svelte-material-icons/Target.svelte';
import Share from 'svelte-material-icons/Share.svelte';
import ShareVariant from 'svelte-material-icons/ShareVariant.svelte';
import Earth from 'svelte-material-icons/Earth.svelte';
import Camcorder from 'svelte-material-icons/Camcorder.svelte';
import Camera from 'svelte-material-icons/Camera.svelte';
import Video from 'svelte-material-icons/Video.svelte';
import Newspaper from 'svelte-material-icons/Newspaper.svelte';

// Finanse i Prawo
import Bank from 'svelte-material-icons/Bank.svelte';
import Cash from 'svelte-material-icons/Cash.svelte';
import CashMultiple from 'svelte-material-icons/CashMultiple.svelte';
import Calculator from 'svelte-material-icons/Calculator.svelte';
import ScaleBalance from 'svelte-material-icons/ScaleBalance.svelte';
import FileDocument from 'svelte-material-icons/FileDocument.svelte';
import FileDocumentOutline from 'svelte-material-icons/FileDocumentOutline.svelte';
import FileExcel from 'svelte-material-icons/FileExcel.svelte';
import CreditCard from 'svelte-material-icons/CreditCard.svelte';
import CreditCardOutline from 'svelte-material-icons/CreditCardOutline.svelte';
import Receipt from 'svelte-material-icons/Receipt.svelte';
import Percent from 'svelte-material-icons/Percent.svelte';
import CurrencyEur from 'svelte-material-icons/CurrencyEur.svelte';
import Scale from 'svelte-material-icons/Scale.svelte';

// IT i Rozwój
import CodeBraces from 'svelte-material-icons/CodeBraces.svelte';
import CodeTags from 'svelte-material-icons/CodeTags.svelte';
import LanConnect from 'svelte-material-icons/LanConnect.svelte';
import Lan from 'svelte-material-icons/Lan.svelte';
import Wifi from 'svelte-material-icons/Wifi.svelte';
import Cloud from 'svelte-material-icons/Cloud.svelte';
import CloudOutline from 'svelte-material-icons/CloudOutline.svelte';
import Web from 'svelte-material-icons/Web.svelte';
import DeveloperBoard from 'svelte-material-icons/DeveloperBoard.svelte';
import Bug from 'svelte-material-icons/Bug.svelte';
import Wrench from 'svelte-material-icons/Wrench.svelte';
import Hammer from 'svelte-material-icons/Hammer.svelte';
import Screwdriver from 'svelte-material-icons/Screwdriver.svelte';
import Tools from 'svelte-material-icons/Tools.svelte';
import Cog from 'svelte-material-icons/Cog.svelte';
import CogOutline from 'svelte-material-icons/CogOutline.svelte';
import Lock from 'svelte-material-icons/Lock.svelte';
import LockOutline from 'svelte-material-icons/LockOutline.svelte';
import Shield from 'svelte-material-icons/Shield.svelte';
import ShieldOutline from 'svelte-material-icons/ShieldOutline.svelte';
import DatabaseLock from 'svelte-material-icons/DatabaseLock.svelte';

// Sprzedaż i Obsługa Klienta
import Store from 'svelte-material-icons/Store.svelte';
import StoreOutline from 'svelte-material-icons/StoreOutline.svelte';
import Cart from 'svelte-material-icons/Cart.svelte';
import CartOutline from 'svelte-material-icons/CartOutline.svelte';
import Shopping from 'svelte-material-icons/Shopping.svelte';
import Tag from 'svelte-material-icons/Tag.svelte';
import TagOutline from 'svelte-material-icons/TagOutline.svelte';
import Sale from 'svelte-material-icons/Sale.svelte';
import Star from 'svelte-material-icons/Star.svelte';
import StarOutline from 'svelte-material-icons/StarOutline.svelte';
import ThumbUp from 'svelte-material-icons/ThumbUp.svelte';
import ThumbUpOutline from 'svelte-material-icons/ThumbUpOutline.svelte';
import Heart from 'svelte-material-icons/Heart.svelte';
import HeartOutline from 'svelte-material-icons/HeartOutline.svelte';
import Headphones from 'svelte-material-icons/Headphones.svelte';
import Human from 'svelte-material-icons/Human.svelte';
import HumanGreeting from 'svelte-material-icons/HumanGreeting.svelte';

// Operacje i Łańcuch Dostaw
import Factory from 'svelte-material-icons/Factory.svelte';
import Truck from 'svelte-material-icons/Truck.svelte';
import TruckOutline from 'svelte-material-icons/TruckOutline.svelte';
import Package from 'svelte-material-icons/Package.svelte';
import PackageVariant from 'svelte-material-icons/PackageVariant.svelte';
import ShipWheel from 'svelte-material-icons/ShipWheel.svelte';
import Airplane from 'svelte-material-icons/Airplane.svelte';
import Home from 'svelte-material-icons/Home.svelte';
import HomeOutline from 'svelte-material-icons/HomeOutline.svelte';
import OfficeBuilding from 'svelte-material-icons/OfficeBuilding.svelte';
import MapMarker from 'svelte-material-icons/MapMarker.svelte';
import MapMarkerOutline from 'svelte-material-icons/MapMarkerOutline.svelte';
import Road from 'svelte-material-icons/Road.svelte';
import Ferry from 'svelte-material-icons/Ferry.svelte';

// Badania i Rozwój
import LightbulbOn from 'svelte-material-icons/LightbulbOn.svelte';
import LightbulbOutline from 'svelte-material-icons/LightbulbOutline.svelte';
import Flask from 'svelte-material-icons/Flask.svelte';
import FlaskOutline from 'svelte-material-icons/FlaskOutline.svelte';
import Microscope from 'svelte-material-icons/Microscope.svelte';
import Atom from 'svelte-material-icons/Atom.svelte';
import Rocket from 'svelte-material-icons/Rocket.svelte';
import RocketOutline from 'svelte-material-icons/RocketOutline.svelte';
import Brain from 'svelte-material-icons/Brain.svelte';
import NoteOutline from 'svelte-material-icons/NoteOutline.svelte';
import NotebookOutline from 'svelte-material-icons/NotebookOutline.svelte';

// Status i Informacja
import Check from 'svelte-material-icons/Check.svelte';
import CheckCircle from 'svelte-material-icons/CheckCircle.svelte';
import CheckCircleOutline from 'svelte-material-icons/CheckCircleOutline.svelte';
import Close from 'svelte-material-icons/Close.svelte';
import CloseCircle from 'svelte-material-icons/CloseCircle.svelte';
import Alert from 'svelte-material-icons/Alert.svelte';
import AlertCircle from 'svelte-material-icons/AlertCircle.svelte';
import AlertOutline from 'svelte-material-icons/AlertOutline.svelte';
import Information from 'svelte-material-icons/Information.svelte';
import InformationOutline from 'svelte-material-icons/InformationOutline.svelte';

// Zarządzanie i Przywództwo
import Crown from 'svelte-material-icons/Crown.svelte';
import Trophy from 'svelte-material-icons/Trophy.svelte';
import TrophyOutline from 'svelte-material-icons/TrophyOutline.svelte';
import Medal from 'svelte-material-icons/Medal.svelte';
import Podium from 'svelte-material-icons/Podium.svelte';
import ChessKing from 'svelte-material-icons/ChessKing.svelte';
import ChessQueen from 'svelte-material-icons/ChessQueen.svelte';
import Presentation from 'svelte-material-icons/Presentation.svelte';
import Gauge from 'svelte-material-icons/Gauge.svelte';
import EyeOutline from 'svelte-material-icons/EyeOutline.svelte';

// Ochrona Zdrowia i Bezpieczeństwo
import MedicalBag from 'svelte-material-icons/MedicalBag.svelte';
import Stethoscope from 'svelte-material-icons/Stethoscope.svelte';
import Hospital from 'svelte-material-icons/Hospital.svelte';
import HospitalBox from 'svelte-material-icons/HospitalBox.svelte';
import Bandage from 'svelte-material-icons/Bandage.svelte';
import Pill from 'svelte-material-icons/Pill.svelte';
import Needle from 'svelte-material-icons/Needle.svelte';
import Biohazard from 'svelte-material-icons/Biohazard.svelte';
import FireExtinguisher from 'svelte-material-icons/FireExtinguisher.svelte';
import Harddisk from 'svelte-material-icons/Harddisk.svelte';
import Thermometer from 'svelte-material-icons/Thermometer.svelte';

export const icons = writable({
	// Komunikacja
	EmailOutline,
	Email,
	SendOutline,
	BellOutline,
	MessageText,
	MessageTextOutline,
	Phone,
	Forum,
	Comment,
	CommentOutline,

	// Kalendarz i czas
	Calendar,
	CalendarClock,
	CalendarMonth,
	CalendarToday,
	Clock,
	ClockOutline,
	ProgressClock,
	Timer,
	TimerOutline,

	// Użytkownicy i zespoły
	Account,
	AccountGroup,
	AccountSearch,
	AccountMultiple,
	AccountCircle,
	AccountOutline,
	AccountSupervisor,
	AccountTie,
	AccountStar,
	AccountKey,
	AccountCog,
	AccountHardHat,
	ShieldAccount,
	Human,
	HumanGreeting,

	// Analityka i wykresy
	ChartGantt,
	MonitorDashboard,
	ChartBar,
	ChartLine,
	ChartPie,
	ChartDonut,
	ChartAreaspline,
	ChartTimeline,
	ChartBellCurve,
	Poll,
	TrendingUp,
	Finance,

	// Marketing i PR
	Bullhorn,
	Target,
	Share,
	ShareVariant,
	Earth,
	Camcorder,
	Camera,
	Video,
	Newspaper,
	PencilOutline,

	// Finanse i Prawo
	CurrencyUsd,
	Bank,
	Cash,
	CashMultiple,
	Calculator,
	ScaleBalance,
	FileDocument,
	FileDocumentOutline,
	FileDocumentEdit,
	FileExcel,
	CreditCard,
	CreditCardOutline,
	Receipt,
	Percent,
	CurrencyEur,
	Scale,
	Briefcase,

	// IT i Rozwój
	Laptop,
	Server,
	Database,
	CodeBraces,
	CodeTags,
	LanConnect,
	Lan,
	Wifi,
	Cloud,
	CloudOutline,
	Web,
	DeveloperBoard,
	Bug,
	Wrench,
	Hammer,
	Screwdriver,
	Tools,
	Cog,
	CogOutline,
	CogSync,
	Lock,
	LockOutline,
	Shield,
	ShieldOutline,
	Security,
	DatabaseLock,
	Cellphone,

	// Sprzedaż i Obsługa Klienta
	Store,
	StoreOutline,
	Cart,
	CartOutline,
	Shopping,
	Tag,
	TagOutline,
	Sale,
	Star,
	StarOutline,
	ThumbUp,
	ThumbUpOutline,
	Heart,
	HeartOutline,
	Headphones,

	// Operacje i Łańcuch Dostaw
	Factory,
	Truck,
	TruckOutline,
	Package,
	PackageVariant,
	ShipWheel,
	Airplane,
	Home,
	HomeOutline,
	OfficeBuilding,
	MapMarker,
	MapMarkerOutline,
	Road,
	Ferry,

	// Badania i Rozwój
	TestTube,
	LightbulbOn,
	LightbulbOutline,
	Flask,
	FlaskOutline,
	Microscope,
	Atom,
	Rocket,
	RocketOutline,
	Brain,
	NoteOutline,
	NotebookOutline,
	Palette,

	// Status i Informacja
	Check,
	CheckCircle,
	CheckCircleOutline,
	CheckboxMarkedCircleOutline,
	Close,
	CloseCircle,
	CloseCircleOutline,
	Alert,
	AlertCircle,
	AlertOutline,
	Information,
	InformationOutline,
	BlockHelper,
	HelpCircleOutline,

	// Zarządzanie i Przywództwo
	Crown,
	Trophy,
	TrophyOutline,
	Medal,
	Podium,
	ChessKing,
	ChessQueen,
	Presentation,
	Gauge,
	EyeOutline,

	// Ochrona Zdrowia i Bezpieczeństwo
	MedicalBag,
	Stethoscope,
	Hospital,
	HospitalBox,
	Bandage,
	Pill,
	Needle,
	Biohazard,
	FireExtinguisher,
	Harddisk,
	Thermometer
});
