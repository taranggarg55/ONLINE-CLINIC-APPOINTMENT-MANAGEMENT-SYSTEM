function MsgBox(msg, title, onOK) {
  try {
    var msgBoxDivStyle =
      "background: rgba(127, 127, 127, 0.6);height: 100%;position: absolute;width: 100%;z-index: 9999;";
    var msgBoxTitleStyle =
      "background-color: #00478A;color: white;font-size: 20px;font-weight: bold;left: 0px;padding: 4px;text-align: left;top: 0px;";
    var msgBoxErrorTitleStyle =
      "background-color: red;color: white;font-size: 20px;font-weight: bold;left: 0px;padding: 4px;text-align: left;top: 0px;";
    var msgBoxSuccessTitleStyle =
      "background-color: green;color: white;font-size: 20px;font-weight: bold;left: 0px;padding: 4px;text-align: left;top: 0px;";
    var msgBoxWarningTitleStyle =
      "background-color: orange;color: white;font-size: 20px;font-weight: bold;left: 0px;padding: 4px;text-align: left;top: 0px;";
    var msgBoxContentsStyle =
      "background: rgba(255, 255, 255, 1);background-color: white;border: 1px solid black;box-shadow: 6px 6px 6px #070707;";
    msgBoxContentsStyle +=
      "left: 30%;position: absolute;resize: vertical;text-align: center;top: 15%;width: 40%;";
    var msgBoxTextStyle =
      "font-size: 18px;overflow: auto;padding: 20px;text-align: center;";
    var msgBoxButtonStyle = "margin: 20px;";

    var msgDiv = "";

    if (title == null) {
      title = "Information";
    }

    if (onOK == null) {
      onOK = "";
    }

    titleStyle = msgBoxTitleStyle;
    if (
      title == "Error" ||
      title == "JavaScript Error" ||
      title == "Exception"
    ) {
      titleStyle = msgBoxErrorTitleStyle;
    } else if (title == "Success") {
      titleStyle = msgBoxSuccessTitleStyle;
    } else if (title == "Warning") {
      titleStyle = msgBoxWarningTitleStyle;
    }

    msgDiv += "<div id='msgboxDiv' style='" + msgBoxDivStyle + "'>"; // Covers the entire body to prevent any interaction with controls in the body.
    msgDiv += "<div id='msgboxContents' style='" + msgBoxContentsStyle + "'>"; // Contains the messagebox itself
    msgDiv +=
      "<div id='msgboxTitle' style='" + titleStyle + "'>" + title + "</div>";
    msgDiv +=
      "<div id='msgboxText' style='" + msgBoxTextStyle + "'>" + msg + "</div>"; // Contains the text of the message to be displayed.
    msgDiv +=
      "<button id='answerOK' tabindex='1' style='" +
      msgBoxButtonStyle +
      "' accesskey='K' onclick='" +
      onOK +
      "document.body.removeChild(this.parentElement.parentElement);'>O<u>K</u></button>";
    msgDiv += "</div></div>"; // Closes the modalBox and modalDiv tags

    document.body.insertAdjacentHTML("afterBegin", msgDiv);

    // This next line is necessary so that the new elements can be referred to in the following JavaScript code.
    document.body.focus();

    // Disable the tab key so that the user can't use it to get to the other controls on the page.
    document.getElementById("answerOK").onkeydown = function (e) {
      if (e.keyCode == 9) {
        return false;
      }
    };
    document.getElementById("answerOK").focus();
  } catch (e) {}
}
